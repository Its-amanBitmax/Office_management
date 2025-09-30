<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Preview Agreement: ') . $agreement->title }}
        </h2>
    </x-slot>
    <style>
        #pdf-container {
            border: 1px solid #ccc;
            background: white;
            min-height: 80vh;
            overflow-y: auto;
            position: relative;
        }
        .pdf-page-container {
            position: relative;
            margin-bottom: 20px;
        }
        .pdf-overlay {
            position: absolute;
            left: 0; top: 0;
            width: 100%; height: 100%;
            pointer-events: auto;
            z-index: 10;
        }
        .signature-box {
            position: absolute;
            border: 2px solid #c53030;
            background: #fefcbf;
            z-index: 20;
            min-width: 120px;
            min-height: 40px;
            cursor: move;
            padding: 0 .3rem;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.1s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            text-align: center;
        }
        .signature-box.signed {
            border-color: #38a169;
            background: #d1fae5;
            cursor: default;
        }
        .signature-status {
            position: absolute;
            bottom: 2px;
            right: 2px;
            background: #38a169;
            color: #fff;
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 0.25rem;
        }
        #signature-modal {
            background: rgba(31, 41, 55, 0.8);
        }
        @media(max-width: 1024px) {
            .w-64 { width: 95vw !important; left:0 !important; right: 0 !important; position: static !important; }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            {{-- LEFT: PDF --}}
            <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative">
                <div class="p-6">
                    <div id="pdf-container"></div>
                </div>
            </div>

            {{-- RIGHT: Sidebar --}}
            <div class="w-64 ml-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg fixed right-10 top-24 h-[calc(100vh-6rem)] overflow-y-auto">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Actions</h3>
                    <h4 class="text-md font-medium mt-4 mb-2">Signers</h4>
                    <div id="signers-list"></div>
                    <button id="add-signer" class="mt-2 bg-gray-500 hover:bg-gray-700 text-white py-1 px-2 rounded text-sm w-full">+ Add Signer</button>
                    <select id="signer-select" class="mt-4 block w-full rounded-md border-gray-300 shadow-sm mb-2">
                        <option value="">Select Signer</option>
                    </select>
                    <button id="add-signature" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Add Signature</button>
                    <div id="signatures" class="mt-4"></div>
                    <button id="save-signatures" class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">Save Signatures</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Signature Modal -->
    <div id="signature-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="fixed inset-0" style="background: rgba(31,41,55,.7);" onclick="closeSignatureModal()"></div>
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6 z-10" style="min-height: 400px;">
            <div class="text-center">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Sign Document</h3>
                <p class="text-sm text-gray-600 mb-4">Draw your signature below:</p>
                <div id="signature-canvas-container">
                    <canvas id="signature-canvas" class="border-2 border-gray-300 rounded-lg bg-white mb-4" style="width:100%;max-width:400px;height:200px;"></canvas>
                </div>
                <div class="flex space-x-2 justify-center mt-4">
                    <button id="clear-signature" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-md">Clear</button>
                    <button id="save-signature" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-black font-medium rounded-md">Save</button>
                    <button id="cancel-signature" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-black font-medium rounded-md">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // ======== Variables ==========
        let pdfDoc = null,
            pageDivs = {},
            overlays = {},
            signatures = {},  // pageNum => Boxes
            signers = [],
            signatureIdCounter = 1,
            currentSignatureBox = null,
            currentSignatureId = null,
            signaturePad = null,
            draggingBox = null,
            dragOffsetX, dragOffsetY, dragBoxPage = null;

        const pdfContainer = document.getElementById('pdf-container');
        const signersList = document.getElementById('signers-list');
        const signerSelect = document.getElementById('signer-select');
        const addSignatureBtn = document.getElementById('add-signature');
        const signaturesDiv = document.getElementById('signatures');

        // ======== Load PDF ==========
        const pdfPath = '{{ asset("storage/" . $agreement->file_path) }}';
        if (!pdfPath || pdfPath.includes('undefined') || pdfPath.includes('null')) {
            pdfContainer.innerHTML = '<div class="error-message">Invalid PDF path. Please check the agreement file path.</div>';
        } else {
            pdfjsLib.getDocument(pdfPath).promise.then(function(pdf) {
                pdfDoc = pdf;
                for (let i = 1; i <= pdf.numPages; i++) renderPage(i);
                setTimeout(loadExistingSignatures, 800);
            }).catch(function(err) {
                pdfContainer.innerHTML = `<div class="error-message">Failed to load PDF: ${err.message}</div>`;
            });
        }

        // === Render a PDF page and its drag overlay ===
        function renderPage(pageNum) {
            pdfDoc.getPage(pageNum).then(function(page) {
                const scale = 1.5;
                const viewport = page.getViewport({ scale });
                const pageContainer = document.createElement('div');
                pageContainer.className = 'pdf-page-container';
                pageDivs[pageNum] = pageContainer;

                // Canvas
                const canvas = document.createElement('canvas');
                canvas.width = viewport.width; canvas.height = viewport.height;
                pageContainer.appendChild(canvas);

                // Overlay for signature boxes
                const overlay = document.createElement('div');
                overlay.className = 'pdf-overlay';
                overlay.style.width = viewport.width + 'px';
                overlay.style.height = viewport.height + 'px';
                overlay.style.pointerEvents = 'auto';
                overlay.style.zIndex = '10';
                pageContainer.appendChild(overlay);

                pdfContainer.appendChild(pageContainer);
                overlays[pageNum] = overlay;
                signatures[pageNum] = [];

                // Render PDF
                page.render({ canvasContext: canvas.getContext('2d'), viewport });
            });
        }

        // ======== Add/Select Signer UI ==========
        let signerCount = 1;
        document.getElementById('add-signer').onclick = function() {
            const div = document.createElement('div');
            div.className = 'p-2 bg-gray-100 rounded mb-2';
            div.innerHTML = `
                <input type="text" class="name-input block w-full mt-1 mb-2 rounded-md border-gray-300 shadow-sm" placeholder="Name" />
                <input type="email" class="email-input block w-full mt-1 mb-2 rounded-md border-gray-300 shadow-sm" placeholder="Email" />
            `;
            signersList.appendChild(div);
            let opt = document.createElement('option');
            opt.value = signerCount;
            opt.innerText = 'Signer ' + signerCount;
            signerSelect.appendChild(opt);
            signers.push({id: signerCount, div});
            signerCount++;
        };

        // ======== Add Signature Box ==========
        addSignatureBtn.onclick = function() {
            const signerId = signerSelect.value;
            if (!signerId) return alert('Select a signer first.');
            const pageNum = 1;
            const canvas = pageDivs[pageNum].querySelector('canvas');
            const x = (canvas.width - 150) / 2, y = (canvas.height - 40) / 2;
            createSignatureBox(x, y, 150, 40, signatureIdCounter++, pageNum, signerId);
        };

        // ======== Create Signature Box ==========
        function createSignatureBox(x, y, width, height, id, pageNum, signerId) {
            const overlay = overlays[pageNum];
            const div = document.createElement('div');
            div.className = 'signature-box';
            div.style.left = `${x}px`; div.style.top = `${y}px`;
            div.style.width = `${width}px`; div.style.height = `${height}px`;
            div.dataset.id = id; div.dataset.page = pageNum; div.dataset.signer = signerId;
            div.innerHTML = `
                <div class="w-full text-center select-none">
                    Signature for ${signerSelect.options[signerId]?.text || 'Signer'}
                    <br><small>Click to sign</small>
                </div>
            `;
            overlay.appendChild(div);
            signatures[pageNum].push(div);
            setupDraggableBox(div, pageNum);
            addSignatureToSidebar(id, signerId, pageNum, false);
            // Click box opens modal
            div.onclick = function(e) {
                if (div.classList.contains("signed")) return;
                currentSignatureBox = div;
                currentSignatureId = id;
                openSignatureModal();
            };
        }

        // ======== Make Box Draggable =========
        function setupDraggableBox(box, pageNum) {
            box.onmousedown = function(e) {
                // Only allow drag if not signed
                if(box.classList.contains('signed')) return;
                draggingBox = box; dragBoxPage = pageNum;
                dragOffsetX = e.offsetX;
                dragOffsetY = e.offsetY;
                document.body.style.userSelect = "none";
            };
        }
        document.onmouseup = function() {
            draggingBox = null;
            document.body.style.userSelect = "";
        };
        document.onmousemove = function(e) {
            if (!draggingBox) return;
            const overlay = overlays[dragBoxPage];
            const rect = overlay.getBoundingClientRect();
            let x = e.clientX - rect.left - dragOffsetX;
            let y = e.clientY - rect.top - dragOffsetY;
            x = Math.max(0, Math.min(overlay.offsetWidth - draggingBox.offsetWidth, x));
            y = Math.max(0, Math.min(overlay.offsetHeight - draggingBox.offsetHeight, y));
            draggingBox.style.left = `${x}px`; draggingBox.style.top = `${y}px`;
        }

        // ======== Sidebar for Signature List =======
        function addSignatureToSidebar(id, signerId, pageNum, signed) {
            const sigItem = document.createElement('div');
            sigItem.className = 'p-1 bg-gray-200 rounded mt-1 text-sm flex justify-between items-center';
            sigItem.innerHTML = `
                <span>Sig ${id} (${signerSelect.options[signerId]?.text || 'Signer'}) - Page ${pageNum} ${signed ? '(Signed)' : ''}</span>
                <button class="remove-sig bg-red-500 text-white px-1 rounded text-xs" data-sig-id="${id}">X</button>
            `;
            sigItem.querySelector('.remove-sig').onclick = function() {
                // Remove from overlay and sidebar
                const boxes = signatures[pageNum];
                const idx = boxes.findIndex(b => b.dataset.id == id);
                if (idx > -1) { boxes[idx].remove(); boxes.splice(idx,1); }
                sigItem.remove();
            };
            signaturesDiv.appendChild(sigItem);
        }

        // ======== Signature Modal =======
        function openSignatureModal() {
            document.getElementById('signature-modal').classList.remove('hidden');
            setTimeout(function() {
                const canvas = document.getElementById('signature-canvas');
                let dpr = window.devicePixelRatio || 1;
                canvas.width = canvas.offsetWidth * dpr;
                canvas.height = canvas.offsetHeight * dpr;
                const ctx = canvas.getContext('2d');
                ctx.scale(dpr, dpr);
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, canvas.offsetWidth, canvas.offsetHeight);
                if (signaturePad) signaturePad.clear();
                signaturePad = new window.SignaturePad(canvas, { minWidth: 1, maxWidth: 4 });
            }, 50);
        }
        function closeSignatureModal() {
            document.getElementById('signature-modal').classList.add('hidden');
            if (signaturePad) signaturePad.clear();
        }
        document.getElementById('clear-signature').onclick = () => signaturePad.clear();
        document.getElementById('cancel-signature').onclick = closeSignatureModal;

        // ======== Save Signature (modal) =======
        document.getElementById('save-signature').onclick = function() {
            if (signaturePad.isEmpty()) return alert('Please sign before saving.');
            const dataURL = signaturePad.toDataURL('image/png');
            fetch("{{ route('admin.agreements.signatures.sign', [$agreement, ':id']) }}".replace(':id', currentSignatureId), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ signature_image: dataURL })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    currentSignatureBox.classList.add('signed');
                    currentSignatureBox.innerHTML = `<img src="${data.signature_image}" style="max-width:100%;max-height:90%;" /><span class="signature-status">Signed</span>`;
                    closeSignatureModal();
                } else alert('Error saving signature: ' + (data.message || 'Unknown'));
            });
        };

        // ======== Load Existing Signatures ========
        function loadExistingSignatures() {
            fetch("{{ route('admin.agreements.signatures.index', $agreement) }}", {
                headers: { Accept: 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                signaturesDiv.innerHTML = '';
                Object.values(signatures).forEach(arr => arr.forEach(x=>x.remove()));
                for (let sig of data.signatures) {
                    createExistingSignatureBox(sig);
                }
            });
        }
        function createExistingSignatureBox(sig) {
            const pageNum = sig.page_number;
            const overlay = overlays[pageNum];
            if (!overlay) return;
            const box = document.createElement('div');
            box.className = 'signature-box' + (sig.status === 'signed' ? ' signed' : '');
            box.style.left = `${sig.x_position}px`;
            box.style.top = `${sig.y_position}px`;
            box.style.width = `${sig.width}px`;
            box.style.height = `${sig.height}px`;
            box.dataset.id = sig.id;
            box.dataset.signer = sig.signer_id;
            box.dataset.page = pageNum;
            if (sig.status === 'signed' && sig.signature_image) {
                box.innerHTML = `<img src="${sig.signature_image}" style="max-width:100%;max-height:90%;" /><span class="signature-status">Signed</span>`;
            } else {
                box.innerHTML = `<div>Signature for ${sig.signer_name}<br><small>Click to sign</small></div>`;
                box.onclick = function(e) {
                    if (box.classList.contains("signed")) return;
                    currentSignatureBox = box;
                    currentSignatureId = sig.id;
                    openSignatureModal();
                };
            }
            overlay.appendChild(box);
            signatures[pageNum].push(box);
            setupDraggableBox(box, pageNum);
            addSignatureToSidebar(sig.id, sig.signer_id, pageNum, sig.status === 'signed');
        }

        // ======== Save All Signatures =========
        document.getElementById('save-signatures').onclick = function() {
            let saveData = [];
            Object.keys(signatures).forEach(pageNum => {
                signatures[pageNum].forEach(box => {
                    const signerDiv = signers.find(s => s.id == box.dataset.signer)?.div,
                          name = signerDiv?.querySelector('.name-input')?.value || '',
                          email = signerDiv?.querySelector('.email-input')?.value || '';
                    saveData.push({
                        id: box.dataset.id,
                        signer_name: name,
                        signer_email: email,
                        x_position: parseFloat(box.style.left),
                        y_position: parseFloat(box.style.top),
                        width: parseFloat(box.style.width),
                        height: parseFloat(box.style.height),
                        page_number: parseInt(pageNum)
                    });
                });
            });
            fetch("{{ route('admin.agreements.signatures.store', $agreement) }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ signatures: saveData })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Signatures saved successfully!');
                    loadExistingSignatures();
                } else {
                    alert('Error saving: ' + (data.errors ? Object.values(data.errors).flat().join('\n') : 'Unknown error'));
                }
            });
        };
    </script>
</x-app-layout>
