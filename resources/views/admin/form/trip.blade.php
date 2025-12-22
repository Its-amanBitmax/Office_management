 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitMax Group - Tour Conveyance Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', 'Calibri', 'Arial', sans-serif;
        }
        
        :root {
            --primary-color: #1a3a8f;
            --secondary-color: #0e5c8a;
            --accent-color: #f8fafc;
            --text-color: #1e293b;
            --light-text: #64748b;
            --border-color: #cbd5e1;
            --success-color: #059669;
            --warning-color: #d97706;
        }
        
        body {
            background: #f1f5f9;
            color: var(--text-color);
            padding: 15px;
            font-size: 13px;
            line-height: 1.4;
        }
        
        .container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 15mm;
            position: relative;
        }
        
        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-logo {
            height: 65px;
            width: auto;
            margin-bottom: 8px;
        }
        
        .company-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 3px;
        }
        
        .company-address {
            font-size: 11px;
            color: var(--light-text);
            margin-bottom: 5px;
        }
        
        .form-title {
            text-align: right;
            flex: 1;
        }
        
        .form-title h1 {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .form-title .subtitle {
            font-size: 13px;
            color: var(--light-text);
            font-weight: 500;
        }
        
        .form-id {
            background: var(--primary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-top: 8px;
        }
        
        /* Form Sections */
        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 8px;
            font-size: 13px;
        }
        
        /* Grid Layout */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 12px;
        }
        
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .form-group {
            margin-bottom: 8px;
        }
        
        label {
            display: block;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .required::after {
            content: " *";
            color: #dc2626;
        }
        
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 12px;
            background: white;
            transition: all 0.2s;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(26, 58, 143, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 60px;
            font-family: inherit;
        }
        
        /* Table Styling */
        .table-container {
            overflow-x: auto;
            margin: 12px 0;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        
        th {
            background: #f1f5f9;
            color: var(--text-color);
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }
        
        td {
            padding: 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        .table-input {
            width: 100%;
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            font-size: 12px;
            background: white;
        }
        
        .table-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        .amount-cell {
            font-weight: 600;
            color: var(--success-color);
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin: 12px 0;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        
        .btn-sm {
            padding: 4px 8px;
            font-size: 11px;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: #152b6e;
        }
        
        .btn-success {
            background: var(--success-color);
            color: white;
        }
        
        .btn-success:hover {
            background: #047857;
        }
        
        .btn-danger {
            background: #dc2626;
            color: white;
        }
        
        .btn-danger:hover {
            background: #b91c1c;
        }
        
        /* Total Amount */
        .total-section {
            display: flex;
            justify-content: flex-end;
            margin: 15px 0;
        }
        
        .total-box {
            background: #f8fafc;
            border: 2px solid var(--primary-color);
            border-radius: 6px;
            padding: 12px 20px;
            text-align: right;
            min-width: 250px;
        }
        
        .total-label {
            font-size: 13px;
            color: var(--light-text);
            margin-bottom: 5px;
        }
        
        .total-amount {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        /* Signature Section */
        .signature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }
        
        .signature-box {
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background: #f8fafc;
        }
        
        .signature-line {
            height: 1px;
            background: #1e293b;
            margin: 25px 0 5px 0;
        }
        
        /* Footer */
        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            font-size: 11px;
            color: var(--light-text);
            text-align: center;
        }
        
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
        }
        
        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 60mm 15mm 15mm 15mm;
                box-shadow: none;
            }
            
            .no-print {
                display: none !important;
            }
            
            .table-container {
                border: 1px solid #ddd;
                overflow: visible;
            }
            
            table {
                border: 1px solid #ddd;
            }
            
            th {
                background: #f5f5f5 !important;
                -webkit-print-color-adjust: exact;
            }
            
            input, select, textarea {
                border: none !important;
                background: transparent !important;
                padding: 0 !important;
            }
            
            .table-input {
                border: none !important;
                padding: 0 !important;
            }
            
            .signature-box {
                border: 1px solid #ddd;
            }
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .container {
                width: 100%;
                padding: 20px;
            }

            .print-controls {
                position: static;
                margin-bottom: 20px;
                justify-content: center;
            }
        }

        /* Screen display adjustments */
        @media screen {
            .container {
                height: auto;
                min-height: unset;
            }
        }
    </style>
</head>
<body>
    <div class="print-controls no-print">
        <button class="btn btn-primary" id="saveBtn">
            <i class="fas fa-save"></i> Save Form
        </button>
        <button class="btn btn-primary" id="downloadBtn">
            <i class="fas fa-file-pdf"></i> Download PDF
        </button>
        <button class="btn btn-success" id="printBtn">
            <i class="fas fa-print"></i> Print Form
        </button>
        <button class="btn btn-danger" id="resetBtn">
            <i class="fas fa-redo"></i> Reset
        </button>

    </div>
    
    <div class="container" id="formContainer">
        <!-- Header -->
        <div class="header" style="margin-top: 25px;">
            <div class="company-info">
                @if($admin && $admin->company_logo && \Illuminate\Support\Facades\Storage::disk('public')->exists('company_logos/' . $admin->company_logo))
                    <img src="{{ asset('storage/company_logos/' . $admin->company_logo) }}"
                         alt="{{ $admin->company_name ?? 'Company Logo' }}"
                         class="company-logo">
                @else
                    <img src="/storage/company_logos/1757255588.png"
                         alt="BitMax Group Logo"
                         class="company-logo">
                @endif
                <div class="form-group" style="margin-bottom: 5px;">
                    <input type="text" id="companyName" value="{{ $form->company_name ?? $admin->company_name ?? '' }}" {{ $form ? 'readonly' : '' }} style="font-size: 22px; font-weight: 700; color: var(--primary-color); border: none; background: transparent; width: 100%;">
                </div>
                <div class="form-group" style="margin-bottom: 5px;">
                    <input type="text" id="companyAddress" value="{{ $form->company_address ?? 'Corporate Office: ' . ($admin->phone ?? '') }}" {{ $form ? 'readonly' : '' }} style="font-size: 11px; color: var(--light-text); border: none; background: transparent; width: 100%;">
                </div>
                <div class="form-group">
                    <input type="text" id="formId" value="{{ $form->form_code ?? 'FORM: BMG-TCF-001' }}" {{ $form ? 'readonly' : '' }} style="background: var(--primary-color); color: white; padding: 5px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; border: none; width: auto;">
                </div>
            </div>
            <div class="form-title">
                <div class="form-group" style="margin-bottom: 8px;">
                    <input type="text" id="formTitle" value="{{ $form->form_heading ?? 'TOUR CONVEYANCE FORM' }}"  style="font-size: 24px; color: var(--primary-color); font-weight: 700; border: none; background: transparent; width: 100%; text-align: right;">
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <input type="text" id="formSubtitle" value="{{ $form->form_subheading ?? 'Employee Business Travel Expense Claim' }}"  style="font-size: 13px; color: var(--light-text); font-weight: 500; border: none; background: transparent; width: 100%; text-align: right;">
                </div>
                <div style="font-size: 12px; margin-top: 10px; color: var(--light-text);">
                    Date: <input type="date" id="formDateInput" value="{{ $form->form_date ?? '' }}"  style="border: none; background: transparent; color: var(--light-text); font-size: 12px; width: auto;">
                </div>
            </div>
        </div>
        
        <!-- Company & Employee Details -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-user-tie"></i> Employee Details
            </div>
            <div class="grid-4">
                <div class="form-group">
                    <label class="required">Employee Name</label>
                    <input type="text" id="empName" value="{{ $form->employee_name ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label class="required">Employee ID</label>
                    <input type="text" id="empId" value="{{ $form->employee_id ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label class="required">Designation</label>
                    <input type="text" id="designation" value="{{ $form->designation ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label class="required">Department</label>
                    <input type="text" id="department" value="{{ $form->department ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="required">Reporting Manager</label>
                    <input type="text" id="manager" value="{{ $form->reporting_manager ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label class="required">Cost Center</label>
                    <input type="text" id="costCenter" value="{{ $form->cost_center ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
            </div>
        </div>
        
        <!-- Tour Details -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-plane-departure"></i> Tour Details
            </div>
            <div class="form-group">
                <label class="required">Purpose of Tour</label>
                <textarea id="purpose" {{ $form ? 'readonly' : '' }}>{{ $form->purpose ?? '' }}</textarea>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="required">Tour Location (From – To)</label>
                    <input type="text" id="tourLocation" value="{{ $form->tour_location ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label class="required">Project Code (if applicable)</label>
                    <input type="text" id="projectCode" value="{{ $form->project_code ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="required">Tour Period From</label>
                    <input type="date" id="tourFrom" value="{{ $form->tour_from ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
                <div class="form-group">
                    <label class="required">Tour Period To</label>
                    <input type="date" id="tourTo" value="{{ $form->tour_to ?? '' }}" {{ $form ? 'readonly' : '' }}>
                </div>
            </div>
        </div>
        
        <!-- Conveyance Details -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-receipt"></i> Conveyance Details
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary btn-sm" id="addRowBtn">
                    <i class="fas fa-plus"></i> Add Row
                </button>
            </div>

            <div class="table-container">
                <table id="conveyanceTable">
                    <thead>
                        <tr>
                            <th width="12%">Date</th>
                            <th width="15%">Mode of Travel</th>
                            <th width="20%">From</th>
                            <th width="20%">To</th>
                            <th width="12%">Distance (Km)</th>
                            <th width="12%">Amount (₹)</th>
                            <th width="9%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Rows will be added here -->
                    </tbody>
                </table>
            </div>

            <div class="total-section">
                <div class="total-box">
                    <div class="total-label">Total Amount Claimed</div>
                    <div class="total-amount">₹ <span id="totalAmount">0.00</span></div>
                </div>
            </div>
        </div>

        <!-- Advance & Settlement -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-money-bill-wave"></i> Advance & Settlement
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label>Advance Taken</label>
                    <input type="number" id="advanceTaken" value="{{ $form->advance_taken ?? '0.00' }}" step="0.01" onchange="updateCalculations()">
                </div>
                <div class="form-group">
                    <label>Total Expense</label>
                    <input type="number" id="totalExpense" value="{{ $form->total_expense ?? '0.00' }}" step="0.01" readonly>
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label>Balance Payable</label>
                    <input type="number" id="balancePayable" value="{{ $form->balance_payable ?? '0.00' }}" step="0.01" readonly>
                </div>
                <div class="form-group">
                    <label>Balance Receivable</label>
                    <input type="number" id="balanceReceivable" value="{{ $form->balance_receivable ?? '0.00' }}" step="0.01" readonly>
                </div>
            </div>
        </div>

        <!-- Approvals -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-check-circle"></i> Approvals & Authorization
            </div>

            <div class="signature-grid">
                <!-- Employee Declaration -->
                <div class="signature-box">
                    <div class="form-group" style="margin-bottom: 8px;">
                        <span style="font-weight: 600; width: 100%; font-size: 12px; color: var(--text-color);">Employee Declaration</span>
                    </div>
                    <div class="form-group" style="margin-bottom: 8px;">
                        <div style="min-height: 40px; font-size: 11px; line-height: 1.4; margin: 0; width: 100%;">I hereby declare that all the information provided in this form is true and correct to the best of my knowledge. All expenses claimed are for official purposes only and are supported by valid receipts.</div>
                    </div>
                    <div class="signature-line"></div>
                    <div style="margin-top: 5px;">
                        <div class="form-group" style="margin-bottom: 5px;">
                            <span style="font-weight: 600; font-size: 11px;">Name:</span> <input type="text" id="empSignature" value="{{ $form->employee_signature ?? '' }}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 50px);">
                        </div>
                        <div class="form-group">
                            <span style="font-weight: 600; font-size: 11px;">Date:</span> <input type="text" id="empDate" value="{{ $form->employee_date ?? '' }}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 50px);">
                        </div>
                    </div>
                </div>

                <!-- Manager Approval -->
                <div class="signature-box">
                    <div class="form-group" style="margin-bottom: 8px;">
                        <span style="font-weight: 600; width: 100%; font-size: 12px; color: var(--text-color);">Reporting Manager</span>
                    </div>
                    <div class="form-group" style="margin-bottom: 8px;">
                        <div style="min-height: 50px; font-size: 11px; line-height: 1.4; margin: 0; width: 100%;">I have reviewed the tour conveyance request and hereby approve the expenses claimed. All expenses appear to be reasonable and necessary for the business purpose.</div>
                    </div>
                    <div class="signature-line"></div>
                    <div style="margin-top: 5px;">
                        <div class="form-group" style="margin-bottom: 5px;">
                            <span style="font-weight: 600; font-size: 11px;">Name:</span> <input type="text" id="managerSignature" value="{{ $form->manager_signature ?? '' }}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 50px);">
                        </div>
                        <div class="form-group" style="margin-bottom: 5px;">
                            <span style="font-weight: 600; font-size: 11px;">Date:</span> <input type="text" id="managerDate" value="{{ $form->manager_date ?? '' }}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 50px);">
                        </div>
                        <div class="form-group">
                            <span style="font-weight: 600; font-size: 11px;">Status:</span> <input type="text" id="managerStatus" value="{{ $form->manager_status ?? '' }}" style="border: none; background: transparent; font-size: 11px; font-weight: 600; color: var(--success-color); width: calc(100% - 60px);">
                        </div>
                    </div>
                </div>

                <!-- Accounts Verification -->
                <div class="signature-box">
                    <div class="form-group" style="margin-bottom: 8px;">
                        <input type="text" id="accountsLabel" value="Accounts Department" style="font-weight: 600; border: none; background: transparent; width: 100%; font-size: 12px; color: var(--text-color);">
                    </div>
                    <div style="margin: 8px 0;">
                        <div class="form-group" style="margin-bottom: 5px;">
                            <input type="text" id="accountsVerifierLabel" value="Verified By:" style="font-weight: 600; border: none; background: transparent; width: 80px; font-size: 11px;"> <input type="text" id="accountsVerifier" value="{{ $form->accounts_verifier ?? '' }}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 80px);">
                        </div>
                        <div class="form-group">
                            <input type="text" id="approvedAmountLabel" value="Amount:" style="font-weight: 600; border: none; background: transparent; width: 120px; font-size: 11px;"><input type="text" id="approvedAmount" value="{{ $form->approved_amount ?? '0.00' }}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 80px);">
                        </div>
                    </div>
                    <div class="signature-line"></div>
                    <div style="margin-top: 5px;">
                        <div class="form-group" style="margin-bottom: 5px;">
                            <input type="text" id="accountsSignatureLabel" value="Signature:" style="font-weight: 600; border: none; background: transparent; width: 70px; font-size: 11px;"> <input type="text" id="accountsSignature" value="{{ $form->accounts_signature ?? ''}}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 70px);">
                        </div>
                        <div class="form-group">
                            <input type="text" id="accountsDateLabel" value="Date:" style="font-weight: 600; border: none; background: transparent; width: 50px; font-size: 11px;"> <input type="text" id="accountsDate" value="{{ $form->accounts_date ?? '' }}" style="border: none; background: transparent; font-size: 11px; width: calc(100% - 50px);">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="form-group" style="margin-bottom: 5px;">
                <input type="text" id="footerText1" value="BitMax Group - Tour Conveyance Form (TCF) | Version 2.1 | This is a computer generated form" style="font-weight: 600; border: none; background: transparent; width: 100%; font-size: 11px; color: var(--light-text);">
            </div>
            <div class="form-group">
                <input type="text" id="footerText2" value="For queries contact: accounts@bitmaxgroup.com | Phone: +91 22 1234 5678 (Ext. 234)" style="border: none; background: transparent; width: 100%; font-size: 11px; color: var(--light-text);">
            </div>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        // Pass conveyance details from PHP to JavaScript
        const conveyanceDetails = @if(isset($form)) @json($form->conveyanceDetails ?? []) @else @json([]) @endif;

        // Initialize with current date
        document.addEventListener('DOMContentLoaded', function() {
            // Set current date
            const today = new Date();
            const formDateInput = document.getElementById('formDateInput');
            if (formDateInput) formDateInput.value = today.toISOString().split('T')[0];

            const empDateEl = document.getElementById('empDate');
            if (empDateEl) empDateEl.value = formatDate(today);

            const managerDateEl = document.getElementById('managerDate');
            if (managerDateEl) managerDateEl.value = formatDate(addDays(today, 1));

            const accountsDateEl = document.getElementById('accountsDate');
            if (accountsDateEl) accountsDateEl.value = formatDate(addDays(today, 2));

          
            initializeTable();
            updateCalculations();

            // Set employee name in signature
            const empSignatureEl = document.getElementById('empSignature');
            const empNameEl = document.getElementById('empName');
            if (empSignatureEl && empNameEl) empSignatureEl.value = empNameEl.value;

            const managerSignatureEl = document.getElementById('managerSignature');
            const managerEl = document.getElementById('manager');
            if (managerSignatureEl && managerEl) managerSignatureEl.value = managerEl.value;
        });
        
        // Helper functions
        function formatDate(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}/${month}/${year}`;
        }
        
        function addDays(date, days) {
            const result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
        }
        
        // Initialize table with auto-generated rows based on tour dates, merged with existing conveyance details
        function initializeTable() {
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            const tourFrom = document.getElementById('tourFrom').value;
            const tourTo = document.getElementById('tourTo').value;
            const tourLocation = document.getElementById('tourLocation').value;

            // Determine if this is creation mode (no existing data)
            const isCreationMode = !conveyanceDetails || conveyanceDetails.length === 0;

            // Create a map of existing conveyance details by date for quick lookup
            const existingDetails = {};
            if (conveyanceDetails && conveyanceDetails.length > 0) {
                conveyanceDetails.forEach(detail => {
                    existingDetails[detail.travel_date] = detail;
                });
            }

            if (tourFrom && tourTo) {
                const fromDate = new Date(tourFrom);
                const toDate = new Date(tourTo);
                const locations = tourLocation.includes(' – ') ? tourLocation.split(' – ') : ['', ''];

                // Generate rows for each day in the tour period
                for (let date = new Date(fromDate); date <= toDate; date.setDate(date.getDate() + 1)) {
                    const dateStr = date.toISOString().split('T')[0];
                    const isFirstDay = date.getTime() === fromDate.getTime();
                    const isLastDay = date.getTime() === toDate.getTime();

                    // Check if existing data for this date
                    const existing = existingDetails[dateStr];

                    let mode, from, to, distance, amount;

                    if (existing) {
                        // Use existing data
                        mode = existing.mode;
                        from = existing.from_location;
                        to = existing.to_location;
                        distance = existing.distance;
                        amount = existing.amount;
                    } else {
                        // Auto-fill based on day
                        mode = 'Flight';
                        from = locations[0] || '';
                        to = locations[1] || '';
                        distance = '';
                        amount = '';

                        // Set appropriate mode and locations for first and last days
                        if (isFirstDay) {
                            mode = 'Flight';
                            from = locations[0] || '';
                            to = locations[1] || '';
                        } else if (isLastDay) {
                            mode = 'Flight';
                            from = locations[1] || '';
                            to = locations[0] || '';
                        } else {
                            mode = 'Taxi';
                            from = 'Hotel';
                            to = 'Client Office';
                        }
                    }

                    addTableRow(dateStr, mode, from, to, distance, amount, isCreationMode);
                }
            } else {
                // No tour dates: use existing conveyance details or add empty row
                if (conveyanceDetails && conveyanceDetails.length > 0) {
                    conveyanceDetails.forEach(detail => {
                        addTableRow(detail.travel_date, detail.mode, detail.from_location, detail.to_location, detail.distance, detail.amount, false);
                    });
                } else {
                    addTableRow('', '', '', '', '', '', true);
                }
            }

            updateCalculations();
        }
        
        // Add table row
        function addTableRow(date = '', mode = '', from = '', to = '', distance = '', amount = '', isCreationMode = false) {
            // Auto-fill defaults for new rows
            if (date === '') {
                date = document.getElementById('tourFrom').value || '';
            }
            if (mode === '') {
                mode = 'Flight';
            }
            if (from === '') {
                const tourLocation = document.getElementById('tourLocation').value;
                if (tourLocation.includes(' – ')) {
                    const locations = tourLocation.split(' – ');
                    from = locations[0] || '';
                    if (to === '') {
                        to = locations[1] || '';
                    }
                }
            }

            const tableBody = document.getElementById('tableBody');
            const rowId = 'row-' + Date.now();
            const readonlyAttr = isCreationMode ? '' : 'readonly';
            const disabledAttr = isCreationMode ? '' : 'disabled';

            const row = document.createElement('tr');
            row.id = rowId;
            row.innerHTML = `
                <td><input type="date" class="table-input" value="${date}" ${readonlyAttr}></td>
                <td>
                    <select class="table-input" ${disabledAttr}>
                        <option value="">Select</option>
                        <option value="Flight" ${mode === 'Flight' ? 'selected' : ''}>Flight</option>
                        <option value="Train" ${mode === 'Train' ? 'selected' : ''}>Train</option>
                        <option value="Taxi" ${mode === 'Taxi' ? 'selected' : ''}>Taxi</option>
                        <option value="Hotel" ${mode === 'Hotel' ? 'selected' : ''}>Hotel</option>
                        <option value="Visa" ${mode === 'Visa' ? 'selected' : ''}>Visa</option>
                        <option value="Other" ${mode === 'Other' ? 'selected' : ''}>Other</option>
                    </select>
                </td>
                <td><input type="text" class="table-input" value="${from}" ${readonlyAttr}></td>
                <td><input type="text" class="table-input" value="${to}" ${readonlyAttr}></td>
                <td><input type="number" class="table-input" value="${distance}" ${readonlyAttr}></td>
                <td><input type="number" class="table-input" value="${amount}" ${readonlyAttr}></td>
                <td><button class="btn btn-danger btn-sm" onclick="removeRow('${rowId}')"><i class="fas fa-trash"></i></button></td>
            `;

            tableBody.appendChild(row);
            updateCalculations();
        }
        
        // Remove row
        function removeRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                row.remove();
                updateCalculations();
            }
        }
        
        // Update all calculations
        function updateCalculations() {
            // Calculate total amount - select all number inputs in the amount column (6th column)
            const amountInputs = document.querySelectorAll('#tableBody tr td:nth-child(6) input[type="number"]');
            let total = 0;

            amountInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            // Update total display
            const formattedTotal = total.toFixed(2);
            const totalAmountEl = document.getElementById('totalAmount');
            if (totalAmountEl) totalAmountEl.textContent = formattedTotal;

            const totalExpenseEl = document.getElementById('totalExpense');
            if (totalExpenseEl) totalExpenseEl.value = formattedTotal;

            const approvedAmountEl = document.getElementById('approvedAmount');
            if (approvedAmountEl) approvedAmountEl.value = formattedTotal;

            // Calculate advance settlement
            const advanceTakenEl = document.getElementById('advanceTaken');
            const advance = parseFloat(advanceTakenEl ? advanceTakenEl.value : 0) || 0;
            const expense = parseFloat(formattedTotal);

            const balancePayableEl = document.getElementById('balancePayable');
            const balanceReceivableEl = document.getElementById('balanceReceivable');

            if (expense > advance) {
                if (balancePayableEl) balancePayableEl.value = (expense - advance).toFixed(2);
                if (balanceReceivableEl) balanceReceivableEl.value = '0.00';
            } else {
                if (balancePayableEl) balancePayableEl.value = '0.00';
                if (balanceReceivableEl) balanceReceivableEl.value = (advance - expense).toFixed(2);
            }
        }
        
        // Add row button
        document.getElementById('addRowBtn').addEventListener('click', function() {
            addTableRow('', '', '', '', '', '', true); // Add empty row in creation mode
        });

        // Reset button
        document.getElementById('resetBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                // Header
                document.getElementById('companyName').value = '';
                document.getElementById('companyAddress').value = '';
                document.getElementById('formId').value = '';
                document.getElementById('formTitle').value = '';
                document.getElementById('formSubtitle').value = '';
                document.getElementById('formDateInput').value = '';

                // Employee Details
                document.getElementById('empName').value = '';
                document.getElementById('empId').value = '';
                document.getElementById('designation').value = '';
                document.getElementById('department').value = '';
                document.getElementById('manager').value = '';
                document.getElementById('costCenter').value = '';

                // Tour Details
                document.getElementById('purpose').value = '';
                document.getElementById('tourLocation').value = '';
                document.getElementById('projectCode').value = '';
                document.getElementById('tourFrom').value = '';
                document.getElementById('tourTo').value = '';

                // Advance & Settlement
                document.getElementById('advanceTaken').value = '';

                // Approvals & Authorization
                document.getElementById('empDeclarationText').value = '';
                document.getElementById('empSignature').value = '';
                document.getElementById('empDate').value = '';
                document.getElementById('managerRemarks').value = '';
                document.getElementById('managerSignature').value = '';
                document.getElementById('managerDate').value = '';
                document.getElementById('managerStatus').value = '';
                document.getElementById('accountsVerifier').value = '';
                document.getElementById('approvedAmount').value = '';
                document.getElementById('accountsSignature').value = '';
                document.getElementById('accountsDate').value = '';

                // Footer
                document.getElementById('footerText1').value = '';
                document.getElementById('footerText2').value = '';

                // Conveyance Table
                document.getElementById('tableBody').innerHTML = '';
                addTableRow(); // Add one empty row

                updateCalculations();
            }
        });
        
        // Print button
        document.getElementById('printBtn').addEventListener('click', function() {
            window.print();
        });
        
        // Download PDF button
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;

            // Show loading
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            btn.disabled = true;

            // Get employee name before preparing form
            const employeeName = document.getElementById('empName').value || 'TourConveyance';

            // Preload logo image to ensure it's available for PDF
            const logoImg = document.querySelector('.company-logo');
            if (logoImg) {
                // Create a new image element to preload
                const preloadImg = new Image();
                preloadImg.crossOrigin = 'anonymous';
                preloadImg.onload = function() {
                    // Create canvas to convert image to data URL
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = preloadImg.width;
                    canvas.height = preloadImg.height;
                    ctx.drawImage(preloadImg, 0, 0);
                    const dataURL = canvas.toDataURL('image/png');
                    logoImg.src = dataURL;
                    generatePDF(employeeName, btn, originalText);
                };
                preloadImg.onerror = function() {
                    // If logo fails to load, still generate PDF without it
                    generatePDF(employeeName, btn, originalText);
                };
                preloadImg.src = logoImg.src;
            } else {
                generatePDF(employeeName, btn, originalText);
            }
        });

        // Separate PDF generation function
        function generatePDF(employeeName, btn, originalText) {
            // Prepare form for PDF
            prepareForPDF();

            // Get the container element
            const element = document.getElementById('formContainer');

            // Apply print-like styles to match print output
            element.style.width = '100%';
            element.style.minHeight = 'auto';
            element.style.margin = '0';
            element.style.boxShadow = 'none';
            element.style.padding = '60mm 15mm 15mm 15mm';

            // Use html2canvas to capture the form with improved settings
            html2canvas(element, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                logging: false,
                backgroundColor: '#ffffff',
                scrollX: 0,
                scrollY: 0,
                windowWidth: element.scrollWidth,
                windowHeight: element.scrollHeight,
                width: element.offsetWidth,
                height: element.offsetHeight
            }).then(canvas => {
                // Create PDF
                const imgData = canvas.toDataURL('image/png');
                const pdfWidth = 210; // A4 width in mm
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');

                // If content is taller than one page, split into multiple pages
                const pageHeight = 297; // A4 height in mm
                let yPosition = 0;

                while (yPosition < pdfHeight) {
                    if (yPosition > 0) {
                        pdf.addPage();
                    }

                    const remainingHeight = Math.min(pageHeight, pdfHeight - yPosition);
                    const sourceY = (yPosition / pdfHeight) * canvas.height;
                    const sourceHeight = (remainingHeight / pdfHeight) * canvas.height;

                    // Create a temporary canvas for this page
                    const pageCanvas = document.createElement('canvas');
                    const pageCtx = pageCanvas.getContext('2d');
                    pageCanvas.width = canvas.width;
                    pageCanvas.height = sourceHeight;

                    pageCtx.drawImage(
                        canvas,
                        0, sourceY, canvas.width, sourceHeight,
                        0, 0, canvas.width, sourceHeight
                    );

                    const pageImgData = pageCanvas.toDataURL('image/png');
                    pdf.addImage(pageImgData, 'PNG', 0, 0, pdfWidth, remainingHeight);

                    yPosition += pageHeight;
                }

                // Save PDF
                const fileName = `BitMax_TCF_${employeeName.replace(/\s+/g, '_')}_${new Date().getTime()}.pdf`;
                pdf.save(fileName);

                // Restore form
                restoreAfterPDF();

                // Restore button
                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(error => {
                console.error('Error generating PDF:', error);
                alert('Error generating PDF. Please try the print function instead.');

                // Restore form
                restoreAfterPDF();

                // Restore button
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
        
        // Prepare form for PDF export
        function prepareForPDF() {
            // Convert form groups to include labels with values for PDF
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach(group => {
                const label = group.querySelector('label');
                const input = group.querySelector('input, select, textarea');

                if (label && input) {
                    let value = '';

                    if (input.type === 'date') {
                        value = input.value ? formatDate(input.value) : '';
                    } else if (input.type === 'number') {
                        value = input.value ? parseFloat(input.value).toFixed(2) : '0.00';
                        if (input.id !== 'advanceTaken') {
                            value = '₹ ' + value;
                        }
                    } else if (input.tagName === 'SELECT') {
                        value = input.options[input.selectedIndex].text;
                    } else {
                        value = input.value;
                    }

                    // Store original HTML
                    group.setAttribute('data-original', group.innerHTML);

                    // Replace with label and value
                    const labelText = label.textContent.replace(' *', ''); // Remove asterisk
                    group.innerHTML = `<div style="padding: 2px 0; min-height: 20px; font-weight: 600;">${labelText}: ${value}</div>`;
                }
            });
            
            // Convert table inputs to text
            const tableRows = document.querySelectorAll('#tableBody tr');
            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');

                // Remove action column
                if (cells.length > 6) {
                    cells[6].remove();
                }

                // Convert each cell
                cells.forEach((cell, index) => {
                    const input = cell.querySelector('input, select');
                    if (input) {
                        let value = '';

                        if (input.type === 'date') {
                            value = input.value ? formatDate(input.value) : '';
                        } else if (input.type === 'number') {
                            value = input.value || '0';
                            if (index === 5) { // Amount column
                                value = '₹ ' + (parseFloat(value) || 0).toFixed(2);
                                cell.className = 'amount-cell';
                            }
                        } else if (input.tagName === 'SELECT') {
                            value = input.options[input.selectedIndex].text;
                        } else {
                            value = input.value;
                        }

                        // Store original HTML
                        cell.setAttribute('data-original', cell.innerHTML);

                        cell.innerHTML = value;
                    }
                });
            });
            
            // Hide print controls
            document.querySelector('.print-controls').style.display = 'none';
        }
        
        // Restore form after PDF export
        function restoreAfterPDF() {
            // Show print controls
            document.querySelector('.print-controls').style.display = 'flex';

            // Restore inputs from stored data
            const elements = document.querySelectorAll('[data-original]');
            elements.forEach(element => {
                element.innerHTML = element.getAttribute('data-original');
            });

            // Re-initialize table
            initializeTable();

            // Re-attach event listeners (no addRowBtn or remove buttons in readonly form)

            // Update calculations
            updateCalculations();
        }
        


        // Auto-calculate taxi fare (optional feature)
        document.addEventListener('change', function(e) {
            if (e.target.matches('select') || e.target.matches('input[type="number"]')) {
                const row = e.target.closest('tr');
                if (!row) return;

                const modeSelect = row.querySelector('select');
                const distanceInput = row.querySelector('input[type="number"]:nth-child(5)');
                const amountInput = row.querySelector('input[type="number"]:nth-child(6)');

                // Only auto-calculate if amount is empty or 0
                if (modeSelect && distanceInput && amountInput &&
                    (!amountInput.value || amountInput.value === '0') &&
                    distanceInput.value && parseFloat(distanceInput.value) > 0) {

                    const distance = parseFloat(distanceInput.value);
                    let rate = 0;

                    switch(modeSelect.value) {
                        case 'Taxi': rate = 18; break;
                        case 'Train': rate = 5; break;
                        default: rate = 0;
                    }

                    if (rate > 0) {
                        amountInput.value = Math.round(distance * rate);
                        updateCalculations();
                    }
                }
            }
        });

        // Save button functionality (assuming saveBtn exists or will be added)
        document.getElementById('saveBtn').addEventListener('click', function () {
            // 🔹 Conveyance rows
            const conveyance = [];
            document.querySelectorAll('#tableBody tr').forEach(row => {
                conveyance.push({
                    travel_date: row.querySelector('td:nth-child(1) input')?.value,
                    mode: row.querySelector('td:nth-child(2) select')?.value,
                    from_location: row.querySelector('td:nth-child(3) input')?.value,
                    to_location: row.querySelector('td:nth-child(4) input')?.value,
                    distance: row.querySelector('td:nth-child(5) input')?.value,
                    amount: row.querySelector('td:nth-child(6) input')?.value,
                });
            });

            fetch("{{ route('admin.form.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    // 🔹 Header
                    form_code: document.getElementById('formId').value,
                    company_name: document.getElementById('companyName').value,
                    company_address: document.getElementById('companyAddress').value,
                    form_heading: document.getElementById('formTitle').value,
                    form_subheading: document.getElementById('formSubtitle').value,
                    form_date: document.getElementById('formDateInput').value,

                    // 🔹 Employee
                    employee_name: document.getElementById('empName').value,
                    employee_id: document.getElementById('empId').value,
                    designation: document.getElementById('designation').value,
                    department: document.getElementById('department').value,
                    reporting_manager: document.getElementById('manager').value,
                    cost_center: document.getElementById('costCenter').value,

                    // 🔹 Tour
                    purpose: document.getElementById('purpose').value,
                    tour_location: document.getElementById('tourLocation').value,
                    project_code: document.getElementById('projectCode').value,
                    tour_from: document.getElementById('tourFrom').value,
                    tour_to: document.getElementById('tourTo').value,

                    // 🔹 Finance
                    advance_taken: document.getElementById('advanceTaken').value,
                    total_expense: document.getElementById('totalExpense').value,
                    balance_payable: document.getElementById('balancePayable').value,
                    balance_receivable: document.getElementById('balanceReceivable').value,

                    // 🔹 Approvals & Authorization
                    employee_declaration: document.getElementById('empDeclarationText').value,
                    employee_signature: document.getElementById('empSignature').value,
                    employee_date: document.getElementById('empDate').value,
                    manager_remarks: document.getElementById('managerRemarks').value,
                    manager_signature: document.getElementById('managerSignature').value,
                    manager_date: document.getElementById('managerDate').value,
                    manager_status: document.getElementById('managerStatus').value,
                    accounts_verifier: document.getElementById('accountsVerifier').value,
                    approved_amount: document.getElementById('approvedAmount').value,
                    accounts_signature: document.getElementById('accountsSignature').value,
                    accounts_date: document.getElementById('accountsDate').value,

                    // 🔹 Footer
                    footer_heading: document.getElementById('footerText1').value,
                    footer_subheading: document.getElementById('footerText2').value,

                    // 🔹 Child table
                    conveyance_details: conveyance
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    alert('Form saved successfully');
                } else {
                    alert(res.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Something went wrong');
            });
        });
    </script>
</body>
</html>
