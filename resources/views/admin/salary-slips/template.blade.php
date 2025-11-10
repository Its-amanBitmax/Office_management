<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Bitmax Technologies Pvt. ltd. — Salary Slip</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
         :root {
            --primary: #1a73e8;
            --light: #e8f0fe;
            --muted: #5f6368;
            --paper: #ffffff;
            --page-bg: #f8f9fa;
            --border: #dadce0;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            background: var(--page-bg);
            font-family: "Poppins", sans-serif;
            color: #202124
        }

        .container {
            display: flex;
            justify-content: center;
            padding: 28px 16px
        }

        .page {
            width: 210mm;
            max-width: 900px;
            background: var(--paper);
            box-sizing: border-box;
            border: 1px solid rgba(26, 115, 232, 0.15);
            padding: 18mm;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .page::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200"><path fill="%231a73e8" fill-opacity="0.03" d="M100 10 L130 60 L190 60 L145 100 L165 150 L100 125 L35 150 L55 100 L10 60 L70 60 Z"/></svg>') center/180px no-repeat;
            z-index: 0;
        }

        .topstrip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            z-index: 2
        }

        .label-strip {
            background: var(--primary);
            color: #fff;
            padding: 6px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px
        }

        .meta {
            font-size: 12px;
            color: #333
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid var(--primary);
            padding: 8px 0 14px 0;
            margin-bottom: 10px;
            z-index: 2
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px
        }

        .logo {
            width: 76px;
            height: 76px;
            border-radius: 12px;
            border: 2px solid var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            overflow: hidden
        }

        .logo img {
            width: 56px;
            height: 56px;
            object-fit: contain
        }

        .company {
            line-height: 1.1
        }

        .company h1 {
            margin: 0;
            color: var(--primary);
            font-size: 19px;
            font-weight: 700
        }

        .company small {
            display: block;
            color: var(--muted);
            font-size: 11.5px;
            margin-top: 4px
        }

        .right-meta {
            text-align: right;
            color: #202124;
            font-size: 12px;
            z-index: 2
        }

        .summary {
            display: flex;
            gap: 18px;
            margin-top: 10px;
            z-index: 2
        }

        .left-col {
            width: 58%
        }

        .right-col {
            width: 42%
        }

        .box {
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 8px;
            background: #fff
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
            color: #202124
        }

        .label {
            color: #444;
            font-weight: 600
        }

        .two-cols {
            display: flex;
            gap: 16px;
            margin-top: 16px;
            align-items: flex-start;
            z-index: 2
        }

        .col {
            flex: 1
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            background: #fff
        }

        th,
        td {
            padding: 10px 8px;
            border: 1px solid #e8f0fe;
            vertical-align: middle
        }

        th {
            background: var(--light);
            color: var(--primary);
            font-weight: 700;
            text-align: left
        }

        td {
            color: #333
        }

        td.right {
            text-align: right;
            color: var(--primary);
            font-weight: 600
        }

        tr.alt {
            background: #fbfffe
        }

        tr.tot-row td {
            background: var(--light);
            font-weight: 700;
            color: var(--primary)
        }

        .total-net {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 28px;
            padding: 18px 26px;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #0d47a1;
            border-radius: 12px;
            font-weight: 700;
            border: 1px solid #90caf9;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
            position: relative;
            z-index: 2;
        }

        .total-net .title {
            font-size: 14px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .total-net .amt {
            font-size: 28px;
            font-weight: 800;
            color: #1976d2;
            letter-spacing: 0.5px;
        }

        .total-net .words {
            position: absolute;
            bottom: -22px;
            right: 0;
            font-size: 12px;
            color: #666;
            font-weight: 500;
            text-align: right;
            width: 100%;
        }

        .sigs {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            z-index: 2
        }

        .sig {
            width: 45%;
            text-align: center;
            font-size: 13px;
            color: #333
        }

        .sig .line {
            border-top: 1px solid #666;
            margin: 26px auto 8px;
            width: 70%
        }

        .footer {
            border-top: 1px solid var(--border);
            padding-top: 10px;
            margin-top: 26px;
            font-size: 11.5px;
            color: #777;
            text-align: center;
            z-index: 2
        }
        /* Hide input borders in PDF */

        input[type="text"],
        input[type="number"] {
            border: none;
            border-bottom: 1px dashed #ccc;
            font-size: 13px;
            padding: 2px 4px;
            width: 120px;
            text-align: right;
            background: transparent;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-bottom: 1px solid var(--primary);
        }
        /* For PDF: Replace input with span */

        .pdf-mode input {
            display: none !important;
        }

        .pdf-mode .input-replace {
            display: inline-block !important;
        }

        .input-replace {
            display: none;
            min-width: 120px;
            text-align: right;
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
        }

        @media print {
            body {
                background: #fff
            }
            .container {
                padding: 0
            }
            .page {
                border: none;
                box-shadow: none;
                margin: 0;
                width: 100%;
                max-width: none;
                padding: 16mm
            }
            .page::before {
                opacity: 0.02
            }
            #downloadPdf {
                display: none
            }
            input {
                display: none;
            }
            .input-replace {
                display: inline-block !important;
            }
        }
    </style>
</head>

<body>

    <!-- Download Button -->
    <div style="position: fixed; top: 16px; right: 16px; z-index: 1000;">
        <button id="downloadPdf" style="padding:10px 18px; background:var(--primary); color:#fff; border:none; border-radius:6px; cursor:pointer; font-weight:600; font-size:14px;">Download PDF</button>
    </div>

    <div class="container">
        <div class="page">

            <div class="topstrip">
                <div class="label-strip">IT PAYROLL</div>
                <div class="meta"><strong>Slip No:</strong>
                    <input type="text" value="TN/HR/2025/1103" id="slipNo">
                    <span class="input-replace" data-for="slipNo">TN/HR/2025/1103</span>
                </div>
            </div>

            <div class="header">
                <div class="brand">
                    <div class="logo">
                        @if($admin && $admin->company_logo)
                            <img src="{{ asset('storage/company_logos/' . $admin->company_logo) }}" alt="{{ $admin->company_name ?? 'Company Logo' }}">
                        @else
                            <img src="storage\app\public\company_logos\1757255588.png" alt="TechNova Logo">
                        @endif
                    </div>
                    <div class="company">
                        <h1>{{ $admin->company_name ?? 'Bitmax Technologies Pvt. Ltd.' }}</h1>
                        <small>{{ config('app.company_address', 'Bhutani Alphathum,Unit - 1034, Tower A, Floor 10th, <br>Noida Expressway, Noida - 201305') }}</small>
                        <small>info@bitmaxtechnology.com • +91 859598686</small>
                    </div>
                </div>
                <div class="right-meta">
                    <div><strong>Pay Period:</strong>
                        <input type="text" value="Oct 2025" id="payPeriod">
                        <span class="input-replace" data-for="payPeriod">Oct 2025</span>
                    </div>
                    <div><strong>Pay Date:</strong>
                        <input type="text" value="31-Oct-2025" id="payDate">
                        <span class="input-replace" data-for="payDate">31-Oct-2025</span>
                    </div>
                </div>
            </div>

            <div class="summary">
                <div class="left-col">
                    <div class="box">
                        <div class="label-row">
                            <div class="label">Employee Name</div>
                            <div>
                                <input type="text" value="Rahul Sharma" id="empName">
                                <span class="input-replace" data-for="empName">Rahul Sharma</span>
                            </div>
                        </div>
                        <div class="label-row">
                            <div class="label">Employee ID</div>
                            <div>
                                <input type="text" value="TN-1103" id="empId">
                                <span class="input-replace" data-for="empId">TN-1103</span>
                            </div>
                        </div>
                        <div class="label-row">
                            <div class="label">Designation</div>
                            <div>
                                <input type="text" value="Senior Software Engineer" id="designation">
                                <span class="input-replace" data-for="designation">Senior Software Engineer</span>
                            </div>
                        </div>
                        <div class="label-row">
                            <div class="label">Department</div>
                            <div>
                                <input type="text" value="Product Engineering" id="department">
                                <span class="input-replace" data-for="department">Product Engineering</span>
                            </div>
                        </div>
                        <div class="label-row">
                            <div class="label">Date of Joining</div>
                            <div>
                                <input type="text" value="15-Mar-2022" id="doj">
                                <span class="input-replace" data-for="doj">15-Mar-2022</span>
                            </div>
                        </div>
                        <div class="label-row">
                            <div class="label">PAN</div>
                            <div>
                                <input type="text" value="ABCDE1234F" id="pan">
                                <span class="input-replace" data-for="pan">ABCDE1234F</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right-col">
                    <div class="box">
                        <div class="label-row">
                            <div class="label">Total Days</div>
                            <div>
                                <input type="number" value="31" id="totalDays">
                                <span class="input-replace" data-for="totalDays">31</span>
                            </div>
                        </div>
                        <div class="label-row">
                            <div class="label">LOP Days</div>
                            <div>
                                <input type="number" value="0" id="lopDays">
                                <span class="input-replace" data-for="lopDays">0</span>
                            </div>
                        </div>

                        <div class="label-row">
                            <div class="label">Paid Days</div>
                            <div>
                                <input type="number" value="0" id="paidDays">
                                <span class="input-replace" data-for="paidDays">0</span>
                            </div>
                        </div>

                        <div class="label-row">
                            <div class="label">Half Days</div>
                            <div>
                                <input type="number" value="0" id="halfDays">
                                <span class="input-replace" data-for="halfDays">0</span>
                            </div>
                        </div>


                        <!-- <div class="label-row">
                            <div class="label">Paid Days</div>
                            <div id="paidDays">31</div>
                         -->
                        <div class="label-row">
                            <div class="label">Bank A/c</div>
                            <div>
                                <input type="text" value="XXXX-XXXX-5678" id="bankAc">
                                <span class="input-replace" data-for="bankAc">XXXX-XXXX-5678</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="two-cols">
                <div class="col">
                    <table>
                        <thead>
                            <tr>
                                <th>EARNINGS</th>
                                <th style="text-align:right">AMOUNT (₹)</th>
                            </tr>
                        </thead>
                        <tbody id="earningsBody">
                            <tr>
                                <td>Basic Salary</td>
                                <td class="right">
                                    <input type="number" class="earn" value="60000">
                                    <span class="input-replace earn-val">60,000.00</span>
                                </td>
                            </tr>



                            <tr>
                                <td>Medical Allowance</td>
                                <td class="right">
                                    <input type="number" class="earn" value="1250">
                                    <span class="input-replace earn-val">1,250.00</span>
                                </td>
                            </tr>
                            <tr class="alt">
                                <td>Leave Travel Allowance (LTA)</td>
                                <td class="right">
                                    <input type="number" class="earn" value="5000">
                                    <span class="input-replace earn-val">5,000.00</span>
                                </td>
                            </tr>
                            <tr class="tot-row">
                                <td>Gross Earnings</td>
                                <td class="right" id="gross">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <table>
                        <thead>
                            <tr>
                                <th>DEDUCTIONS</th>
                                <th style="text-align:right">AMOUNT (₹)</th>
                            </tr>
                        </thead>
                        <tbody id="deductionsBody">
                            <tr>
                                <td>Provident Fund (Employee)</td>
                                <td class="right">
                                    <input type="number" class="deduct" value="1800">
                                    <span class="input-replace deduct-val">1,800.00</span>
                                </td>
                            </tr>
                            <tr class="alt">
                                <td>Professional Tax</td>
                                <td class="right">
                                    <input type="number" class="deduct" value="200">
                                    <span class="input-replace deduct-val">200.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Income Tax (TDS)</td>
                                <td class="right">
                                    <input type="number" class="deduct" value="8500">
                                    <span class="input-replace deduct-val">8,500.00</span>
                                </td>
                            </tr>
                            <tr class="tot-row">
                                <td>Total Deductions</td>
                                <td class="right" id="totalDeductions">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="total-net">
                <div class="title">Net Salary Payable</div>
                <div class="amt" id="netAmount">₹0.00</div>
                <div class="words" id="netWords">(Amount in words)</div>
            </div>

            <div class="sigs">
                <div class="sig">
                    <div class="line"></div>
                    <div>Employee Signature</div>
                </div>
                <div class="sig">
                    <div class="line"></div>
                    <div>Authorized Signatory (HR)</div>
                </div>
            </div>

            <div class="footer" contenteditable="true">
                **This is a system-generated payslip. No signature required.**<br> Bitmax Technologies Pvt. Ltd. | Payroll processed via secure HRMS | For queries: info@bitmaxgroup.com
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const {
            jsPDF
        } = window.jspdf;

        // Sync input → span
        function syncInputs() {
            document.querySelectorAll('input').forEach(input => {
                const span = input.parentElement.querySelector(`.input-replace[data-for="${input.id}"]`) ||
                    input.parentElement.querySelector('.input-replace');
                if (span) {
                    if (input.classList.contains('earn') || input.classList.contains('deduct')) {
                        span.innerText = Number(input.value || 0).toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    } else {
                        span.innerText = input.value;
                    }
                }
            });
        }

        // PDF Download
        document.getElementById('downloadPdf').addEventListener('click', () => {
            const page = document.querySelector('.page');
            const button = document.getElementById('downloadPdf');
            button.disabled = true;
            button.innerText = "Generating...";

            // Sync all values
            syncInputs();
            recalc();

            // Hide inputs, show spans
            page.classList.add('pdf-mode');

            html2canvas(page, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`SalarySlip_${document.getElementById('empName').value || 'Employee'}_${document.getElementById('payPeriod').value || 'Month'}.pdf`);

                // Revert
                page.classList.remove('pdf-mode');
                button.disabled = false;
                button.innerText = "Download PDF";
            }).catch(err => {
                alert("PDF generation failed. Run on Live Server.");
                console.error(err);
                page.classList.remove('pdf-mode');
                button.disabled = false;
                button.innerText = "Download PDF";
            });
        });

        // Calculations
        function formatIN(x) {
            return Number(x).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function recalc() {
            const total = parseInt(document.getElementById('totalDays').value) || 0;
            const lop = parseInt(document.getElementById('lopDays').value) || 0;
            document.getElementById('paidDays').innerText = total - lop;

            let gross = 0;
            document.querySelectorAll('.earn').forEach(inp => gross += parseFloat(inp.value) || 0);

            let ded = 0;
            document.querySelectorAll('.deduct').forEach(inp => ded += parseFloat(inp.value) || 0);

            const net = gross - ded;

            document.getElementById('gross').innerText = formatIN(gross);
            document.getElementById('totalDeductions').innerText = formatIN(ded);
            document.getElementById('netAmount').innerText = '₹' + formatIN(net);
            document.getElementById('netWords').innerText = '(' + convertNumberToWords(Math.round(net)) + ')';

            syncInputs(); // Update spans
        }

        // Number to Words
        function convertNumberToWords(num) {
            const a = ["", "One ", "Two ", "Three ", "Four ", "Five ", "Six ", "Seven ", "Eight ", "Nine ", "Ten ", "Eleven ", "Twelve ", "Thirteen ", "Fourteen ", "Fifteen ", "Sixteen ", "Seventeen ", "Eighteen ", "Nineteen "];
            const b = ["", "", "Twenty ", "Thirty ", "Forty ", "Fifty ", "Sixty ", "Seventy ", "Eighty ", "Ninety "];
            if ((num = num.toString()).length > 9) return "Overflow";
            const n = ("000000000" + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return;
            let str = "";
            str += n[1] != 0 ? (a[Number(n[1])] || b[n[1][0]] + " " + a[n[1][1]]) + "Crore " : "";
            str += n[2] != 0 ? (a[Number(n[2])] || b[n[2][0]] + " " + a[n[2][1]]) + "Lakh " : "";
            str += n[3] != 0 ? (a[Number(n[3])] || b[n[3][0]] + " " + a[n[3][1]]) + "Thousand " : "";
            str += n[4] != 0 ? a[Number(n[4])] + "Hundred " : "";
            str += n[5] != 0 ? ((str != "") ? "and " : "") + (a[Number(n[5])] || b[n[5][0]] + " " + a[n[5][1]]) + "Rupees " : "Rupees ";
            return str.trim() + "Only";
        }

        // Re-calculate on input
        document.querySelectorAll('input').forEach(inp => {
            inp.addEventListener('input', () => {
                recalc();
            });
        });

        window.addEventListener('DOMContentLoaded', () => {
            recalc();
        });
    </script>
</body>

</html>
