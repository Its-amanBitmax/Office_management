@extends('layouts.employee')

@section('title', 'My Reports')

@section('page-title', 'My Reports')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Work Report | Bitmax Group</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        :root {
            --primary: #1a56db;
            --primary-dark: #1e429f;
            --secondary: #6b7280;
            --light: #f9fafb;
            --dark: #111827;
            --border: #d1d5db;
            --radius: 6px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            color: #374151;
            line-height: 1.5;
            padding: 20px;
        }

        .report-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .company-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .company-logo {
            height: 70px;
            width: 120px;
            object-fit: contain;
            display: block;
            max-width: 100%;
        }

        .company-info h1 {
            color: var(--primary);
            font-size: 24px;
            margin-bottom: 5px;
        }

        .company-info p {
            color: var(--secondary);
            font-size: 14px;
        }

        .report-title {
            text-align: center;
            margin: 25px 0;
        }

        .report-title h2 {
            color: var(--dark);
            font-size: 28px;
            margin-bottom: 10px;
        }

        .report-title .subtitle {
            color: var(--secondary);
            font-size: 16px;
            font-weight: normal;
        }

        .report-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            background: var(--light);
            padding: 20px;
            border-radius: var(--radius);
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-item label {
            font-size: 13px;
            color: var(--secondary);
            margin-bottom: 5px;
            font-weight: 500;
        }

        .meta-item input, .meta-item select {
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 14px;
            background: white;
        }

        .meta-item input:focus, .meta-item select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.1);
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-header.team-summary-header {
            justify-content: space-between;
        }

        .section-header.team-summary-header .section-title {
            flex: 1;
        }

        .section-header-toggle {
            justify-content: space-between;
        }

        .section-header-toggle .section-title {
            flex: 1;
        }

        .include-toggle {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            color: var(--secondary);
            cursor: pointer;
        }

        .include-toggle input[type="checkbox"] {
            margin: 0;
        }


        .section-icon {
            background: var(--primary);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 12px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }

        .points-container {
            background: var(--light);
            border-radius: var(--radius);
            padding: 15px;
            page-break-inside: avoid;
        }

        .point-row {
            display: flex;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .point-row:last-child {
            margin-bottom: 0;
        }

        .bullet {
            color: var(--primary);
            margin-right: 10px;
            margin-top: 4px;
            min-width: 20px;
        }

        .point-input {
            flex: 1;
            padding: 8px 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 14px;
            min-height: 36px;
            resize: vertical;
        }

        .point-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .input-group {
            display: flex;
            gap: 10px;
            flex: 1;
        }

        .input-group .point-input {
            flex: 1;
        }

        .team-input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .team-input-group .point-input {
            width: 100%;
        }

        .add-point-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
        }

        .add-point-btn:hover {
            background: var(--primary-dark);
        }

        .remove-point {
            background: #ef4444;
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            margin-left: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .remove-point:hover {
            background: #dc2626;
        }

        .remarks-container {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        .remarks-container textarea {
            width: 100%;
            min-height: 80px;
            padding: 10px;
            border: 1px solid #fbbf24;
            border-radius: var(--radius);
            font-size: 14px;
            background: white;
        }

        .remarks-container textarea:focus {
            outline: none;
            border-color: #f59e0b;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 12px 25px;
            border-radius: var(--radius);
            font-weight: 500;
            cursor: pointer;
            border: none;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn-secondary {
            background: white;
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--light);
        }

        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0 !important;
            }

            .report-container {
                box-shadow: none;
                padding: 20px;
                margin: 0 auto !important;
                transform: none !important;
                page-break-before: avoid;
                page-break-after: avoid;
            }

            .add-point-btn, .remove-point, .form-actions {
                display: none !important;
            }

            .point-input {
                border: none;
                background: transparent;
                padding: 2px 5px;
            }
        }

        @media (max-width: 768px) {
            .company-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .logo-container {
                flex-direction: column;
                text-align: center;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }Aman
            
            .signature-row {
                flex-direction: column;
                gap: 20px;
            }
            
            .signature-box {
                width: 100%;
            }
        }
    </style>
</head>
   <body>
            <div class="report-container">
                <!-- Company Header with Logo -->
                <div class="company-header">
                    <div class="logo-container">
                        <img src="https://res.cloudinary.com/dh2ypqi8l/image/upload/v1770721321/logo_ddcydm.png"
                            alt="Bitmax Group Logo" class="company-logo">
                    
                    </div>
                    <div class="report-code">
                        <div style="font-weight: bold; color: var(--primary);"><h2>Daily Work Report</h2></div>
                        <div style="font-size: 12px; color: var(--secondary);">Professional Progress Tracking & Documentation</div>
                    </div>
                </div>

            

                <!-- Report Metadata -->
                <div class="report-meta">
                    <div class="meta-item">
                        <label for="report-date">Date</label>
                        <input type="date" id="report-date" value="">
                    </div>
                    <div class="meta-item">
                        <label for="employee-name">Reported By</label>
                        <input type="text" id="employee-name" placeholder="Your Full Name">
                    </div>
                    <div class="meta-item">
                        <label for="employee-designation">Designation</label>
                        <input type="text" id="employee-designation" placeholder="Your Position">
                    </div>
                    <div class="meta-item">
                        <label for="department"> Department</label>
                        <select id="department">
                            <option value="it">IT Department</option>
                         
                        </select>
                    </div>
                </div>

                <!-- Project Information -->
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <div class="section-title">Project Information</div>
                    </div>
                    <div class="points-container" id="projects-container">
                        <div class="point-row">
                            <div class="bullet">—</div>
                            <input type="text" class="point-input project-input" placeholder="Enter project name (e.g., )">
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addProjectPoint()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Recipients -->
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="section-title">Report Distribution</div>
                    </div>
                    <div class="points-container" id="distribution-container">
                        <div class="point-row">
                            <div class="bullet">•</div>
                            <div class="input-group">
                                <input type="text" class="point-input distribution-name" placeholder="Name: Full Name">
                                <input type="email" class="point-input distribution-email" placeholder="Email: email@example.com">
                            </div>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addDistributionPoint()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Tasks Completed -->
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="section-title">Tasks Completed</div>
                    </div>
                    <div class="points-container" id="tasks-completed-container">
                        <div class="point-row">
                            <div class="bullet">1.</div>
                            <textarea class="point-input" placeholder="Describe completed task in points"></textarea>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addTaskPoint('tasks-completed-container')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Ongoing / In Progress -->
                <div class="section" id="ongoing-section">
                    <div class="section-header section-header-toggle">
                        <div class="section-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <div class="section-title">Ongoing / In Progress</div>
                        <label class="include-toggle">
                            <input type="checkbox" id="include-ongoing" checked onchange="toggleSection('ongoing-section', 'ongoing-container', 'include-ongoing')">
                            Include
                        </label>
                    </div>
                    <div class="points-container" id="ongoing-container">
                        <div class="point-row">
                            <div class="bullet">•</div>
                            <textarea class="point-input" placeholder="Current working task with status"></textarea>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addTaskPoint('ongoing-container')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Testing / Deployment -->
                <div class="section" id="testing-section">
                    <div class="section-header section-header-toggle">
                        <div class="section-icon">
                            <i class="fas fa-code-branch"></i>
                        </div>
                        <div class="section-title">Testing / Deployment</div>
                        <label class="include-toggle">
                            <input type="checkbox" id="include-testing" checked onchange="toggleSection('testing-section', 'testing-container', 'include-testing')">
                            Include
                        </label>
                    </div>
                    <div class="points-container" id="testing-container">
                        <div class="point-row">
                            <div class="bullet">•</div>
                            <textarea class="point-input" placeholder="Testing or deployment details"></textarea>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addTaskPoint('testing-container')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Issues / Blockers -->
                <div class="section" id="issues-section">
                    <div class="section-header section-header-toggle">
                        <div class="section-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="section-title">Issues / Blockers</div>
                        <label class="include-toggle">
                            <input type="checkbox" id="include-issues" checked onchange="toggleSection('issues-section', 'issues-container', 'include-issues')">
                            Include
                        </label>
                    </div>
                    <div class="points-container" id="issues-container">
                        <div class="point-row">
                            <div class="bullet">•</div>
                            <textarea class="point-input" placeholder="Mention any issues or blockers"></textarea>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addTaskPoint('issues-container')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Team Summary -->
                <div class="section" id="team-summary-section">
                    <div class="section-header team-summary-header">
                        <div class="section-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="section-title">Team Summary</div>
                        <label class="include-toggle">
                            <input type="checkbox" id="include-team-summary" checked onchange="toggleSection('team-summary-section', 'team-container', 'include-team-summary')">
                            Include
                        </label>
                    </div>
                    <div class="points-container" id="team-container">
                        <div class="point-row">
                            <div class="bullet">•</div>
                            <div class="team-input-group">
                                <input type="text" class="point-input team-name" placeholder="Name: Team Member Name">
                                <textarea class="point-input team-summary" placeholder="Summary: Work summary" rows="2"></textarea>
                            </div>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addTaskPoint('team-container')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Plan for Tomorrow -->
                <div class="section" id="plan-section">
                    <div class="section-header section-header-toggle">
                        <div class="section-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="section-title">Plan for Tomorrow</div>
                        <label class="include-toggle">
                            <input type="checkbox" id="include-plan" checked onchange="toggleSection('plan-section', 'plan-container', 'include-plan')">
                            Include
                        </label>
                    </div>
                    <div class="points-container" id="plan-container">
                        <div class="point-row">
                            <div class="bullet">1.</div>
                            <textarea class="point-input" placeholder="Next day plan in points"></textarea>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button class="add-point-btn" onclick="addTaskPoint('plan-container')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Remarks -->
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-sticky-note"></i>
                        </div>
                        <div class="section-title">Remarks</div>
                    </div>
                    <div class="remarks-container">
                        <textarea id="remarks" placeholder="Any important note, dependency, approval required, or special instructions"></textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button class="btn btn-secondary" onclick="clearForm()">
                        <i class="fas fa-redo"></i> Clear Form
                    </button>
                    <button class="btn btn-primary" onclick="generatePDF()">
                        <i class="fas fa-file-pdf"></i> Generate PDF
                    </button>

                </div>
            </div>

            <script>
                // Initialize current date
                document.addEventListener('DOMContentLoaded', function() {
                    const today = new Date();
                    const formattedDate = today.toISOString().split('T')[0];
                    document.getElementById('report-date').value = formattedDate;

                    // Add sample data
                    addSampleData();
                });

                // Function to add project point
                function addProjectPoint() {
                    const container = document.getElementById('projects-container');
                    const pointCount = container.children.length + 1;

                    const pointRow = document.createElement('div');
                    pointRow.className = 'point-row';
                    pointRow.innerHTML = `
                        <div class="bullet">•</div>
                        <input type="text" class="point-input project-input" placeholder="Enter project name">
                        <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                    `;

                    container.appendChild(pointRow);
                    pointRow.querySelector('.point-input').focus();
                }

                // Function to add distribution point
                function addDistributionPoint() {
                    const container = document.getElementById('distribution-container');

                    const pointRow = document.createElement('div');
                    pointRow.className = 'point-row';
                    pointRow.innerHTML = `
                        <div class="bullet">•</div>
                        <div class="input-group">
                            <input type="text" class="point-input distribution-name" placeholder="Name: Full Name">
                            <input type="email" class="point-input distribution-email" placeholder="Email: email@example.com">
                        </div>
                        <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                    `;

                    container.appendChild(pointRow);
                    pointRow.querySelector('.distribution-name').focus();
                }

                // Function to add task point to any container
                function addTaskPoint(containerId) {
                    const container = document.getElementById(containerId);
                    const pointCount = container.children.length + 1;

                    const pointRow = document.createElement('div');
                    pointRow.className = 'point-row';

                    // Use numbers for tasks completed and plan, bullets for others
                    let bullet = '•';
                    if (containerId === 'tasks-completed-container' || containerId === 'plan-container') {
                        bullet = pointCount + '.';
                    }

                    // Special handling for team container
                    if (containerId === 'team-container') {
                        pointRow.innerHTML = `
                            <div class="bullet">${bullet}</div>
                            <div class="team-input-group">
                                <input type="text" class="point-input team-name" placeholder="Name: Team Member Name">
                                <textarea class="point-input team-summary" placeholder="Summary: Work summary" rows="2"></textarea>
                            </div>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        `;
                        container.appendChild(pointRow);
                        pointRow.querySelector('.team-name').focus();
                    } else {
                        pointRow.innerHTML = `
                            <div class="bullet">${bullet}</div>
                            <textarea class="point-input" placeholder="Enter details"></textarea>
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        `;
                        container.appendChild(pointRow);
                        pointRow.querySelector('.point-input').focus();
                    }

                    // Update numbering for tasks completed and plan sections
                    if (containerId === 'tasks-completed-container' || containerId === 'plan-container') {
                        updateNumbering(containerId);
                    }
                }

                // Function to remove a point
                function removePoint(button) {
                    const container = button.closest('.points-container');
                    const pointRow = button.closest('.point-row');
                    
                    if (container.children.length > 1) {
                        pointRow.remove();
                        
                        // Update numbering if needed
                        const containerId = container.id;
                        if (containerId === 'tasks-completed-container' || containerId === 'plan-container') {
                            updateNumbering(containerId);
                        }
                    } else {
                        // If last point, just clear it instead of removing
                        const input = pointRow.querySelector('.point-input');
                        input.value = '';
                        input.placeholder = 'Enter details';
                        input.focus();
                    }
                }

                // Function to update numbering
                function updateNumbering(containerId) {
                    const container = document.getElementById(containerId);
                    const pointRows = container.querySelectorAll('.point-row');
                    
                    pointRows.forEach((row, index) => {
                        const bullet = row.querySelector('.bullet');
                        bullet.textContent = (index + 1) + '.';
                    });
                }

                // Function to add sample data
                function addSampleData() {
                    // Add sample projects
                    const sampleProjects = ['', ''];
                    const projectsContainer = document.getElementById('projects-container');
                    
                    // Clear existing and add samples
                    projectsContainer.innerHTML = '';
                    sampleProjects.forEach(project => {
                        const pointRow = document.createElement('div');
                        pointRow.className = 'point-row';
                        pointRow.innerHTML = `
                            <div class="bullet">•</div>
                            <input type="text" class="point-input project-input" value="${project}">
                            <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                        `;
                        projectsContainer.appendChild(pointRow);
                    });
                    
                    // Add sample task
                    const tasksContainer = document.getElementById('tasks-completed-container');
                    tasksContainer.innerHTML = '';
                    const sampleTask = document.createElement('div');
                    sampleTask.className = 'point-row';
                    sampleTask.innerHTML = `
                        <div class="bullet">1.</div>
                        <textarea class="point-input"></textarea>
                        <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                    `;
                    tasksContainer.appendChild(sampleTask);
                    
                    // Add sample plan
                    const planContainer = document.getElementById('plan-container');
                    planContainer.innerHTML = '';
                    const samplePlan = document.createElement('div');
                    samplePlan.className = 'point-row';
                    samplePlan.innerHTML = `
                        <div class="bullet">1.</div>
                        <textarea class="point-input"></textarea>
                        <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                    `;
                    planContainer.appendChild(samplePlan);
                    
                    // Fill other fields
                    document.getElementById('employee-name').value = '';
                    document.getElementById('employee-designation').value = '';
                    document.getElementById('department').value = 'it';
                    document.getElementById('remarks').value = '';
                }

                // Function to clear form
                function clearForm() {
                    if (confirm('Are you sure you want to clear all form data?')) {
                        // Clear all inputs
                        document.querySelectorAll('input, textarea, select').forEach(element => {
                            if (element.type !== 'button' && element.type !== 'submit') {
                                element.value = '';
                            }
                        });
                        
                        // Clear all points containers
                        document.querySelectorAll('.points-container').forEach(container => {
                            if (container.id === 'distribution-container') {
                                container.innerHTML = `
                                    <div class="point-row">
                                        <div class="bullet">•</div>
                                        <div class="input-group">
                                            <input type="text" class="point-input distribution-name" placeholder="Name: Full Name">
                                            <input type="email" class="point-input distribution-email" placeholder="Email: email@example.com">
                                        </div>
                                        <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                                    </div>
                                `;
                            } else if (container.id === 'team-container') {
                                container.innerHTML = `
                                    <div class="point-row">
                                        <div class="bullet">•</div>
                                        <div class="team-input-group">
                                            <input type="text" class="point-input team-name" placeholder="Name: Team Member Name">
                                            <textarea class="point-input team-summary" placeholder="Summary: Work summary" rows="2"></textarea>
                                        </div>
                                        <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                                    </div>
                                `;
                            } else {
                                container.innerHTML = `
                                    <div class="point-row">
                                        <div class="bullet">•</div>
                                        <textarea class="point-input" placeholder="Enter details"></textarea>
                                        <button class="remove-point" onclick="removePoint(this)"><i class="fas fa-times"></i></button>
                                    </div>
                                `;
                            }
                        });
                        
                        // Set current date
                        const today = new Date();
                        const formattedDate = today.toISOString().split('T')[0];
                        document.getElementById('report-date').value = formattedDate;
                    }
                }

                // Function to convert image URL to base64
                function imageToBase64(url, callback) {
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);
                        const dataURL = canvas.toDataURL('image/png');
                        callback(dataURL);
                    };
                    img.onerror = () => {
                        console.warn('Failed to load image:', url);
                        callback(url); // fallback to original URL
                    };
                    img.src = url;
                }

                // Function to preload and convert images to base64
                function preloadImages(callback) {
                    const images = document.querySelectorAll('img');
                    let processedCount = 0;
                    const totalImages = images.length;

                    if (totalImages === 0) {
                        callback();
                        return;
                    }

                    images.forEach(img => {
                        const originalSrc = img.src;
                        imageToBase64(originalSrc, (base64Data) => {
                            img.src = base64Data;
                            processedCount++;
                            if (processedCount === totalImages) {
                                callback();
                            }
                        });
                    });
                }

                // Function to generate PDF
                function generatePDF() {
                    // Check required fields
                    const requiredFields = ['employee-name'];
                    let missingFields = [];

                    requiredFields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (!field || !field.value.trim()) {
                            missingFields.push(field ? field.placeholder || fieldId : fieldId);
                            if (field) field.style.borderColor = '#ef4444';
                        }
                    });

                    // Check if at least one project is entered
                    const projectInputs = document.querySelectorAll('.project-input');
                    let hasProject = false;
                    projectInputs.forEach(input => {
                        if (input.value.trim()) hasProject = true;
                    });

                    if (!hasProject) {
                        missingFields.push('Project Name');
                        document.querySelector('.project-input').style.borderColor = '#ef4444';
                    }

                    if (missingFields.length > 0) {
                        alert(`Please fill in the following required fields:\n\n• ${missingFields.join('\n• ')}`);
                        return;
                    }

                    // Preload images to base64 before generating PDF
                    preloadImages(() => {
                        const reportContainer = document.querySelector('.report-container');
                        const pdfElement = reportContainer.cloneNode(true);

                        prepareContentForPDF(pdfElement);

                        const options = {
                            margin: 10,
                            filename: 'Daily-Work-Report.pdf',
                            image: { type: 'jpeg', quality: 0.98 },
                            html2canvas: {
                                scale: 1.3,
                                useCORS: true,
                                allowTaint: true,
                                scrollY: 0,
                                windowWidth: document.body.scrollWidth,
                                windowHeight: document.body.scrollHeight
                            },
                            jsPDF: {
                                unit: 'mm',
                                format: 'a4',
                                orientation: 'portrait'
                            }
                        };

                        html2pdf()
                            .set(options)
                            .from(pdfElement)
                            .save()
                            .then(() => prepareContentForPDF(false));
                    });
                }

                // Function to prepare content for PDF generation
                function prepareContentForPDF(element, restore = true) {
                    if (restore) {
                        // Hide buttons and interactive elements
                        const buttons = element.querySelectorAll('.add-point-btn, .remove-point, .form-actions');
                        buttons.forEach(btn => btn.style.display = 'none');

                        // Ensure images are properly loaded for PDF
                        const images = element.querySelectorAll('img');
                        images.forEach(img => {
                            img.style.maxWidth = '100%';
                            img.style.height = 'auto';
                            // Force image to be visible and loaded
                            img.style.display = 'block';
                            img.style.objectFit = 'contain';
                        });

                        // Convert inputs and textareas to display text
                        const inputs = element.querySelectorAll('input, textarea, select');
                        inputs.forEach(input => {
                            if (input.tagName === 'SELECT') {
                                // For dropdowns, show selected option text
                                const selectedOption = input.options[input.selectedIndex];
                                const textSpan = document.createElement('span');
                                textSpan.textContent = selectedOption ? selectedOption.textContent : '';
                                textSpan.style.fontSize = '14px';
                                textSpan.style.lineHeight = '1.5';
                                textSpan.style.display = 'block';
                                textSpan.style.marginBottom = '5px';
                                input.parentNode.replaceChild(textSpan, input);
                            } else if (input.tagName === 'TEXTAREA') {
                                // For textareas, show plain text
                                const textSpan = document.createElement('span');
                                textSpan.textContent = input.value || '';
                                textSpan.style.fontSize = '14px';
                                textSpan.style.lineHeight = '1.5';
                                textSpan.style.whiteSpace = 'pre-wrap';
                                textSpan.style.wordWrap = 'break-word';
                                textSpan.style.border = 'none';
                                textSpan.style.background = 'transparent';
                                textSpan.style.padding = '0';
                                textSpan.style.margin = '0';
                                textSpan.style.display = 'inline';
                                input.parentNode.replaceChild(textSpan, input);
                            } else if (input.type === 'text' || input.type === 'email' || input.type === 'date') {
                                // For text inputs, show plain text
                                const textSpan = document.createElement('span');
                                textSpan.textContent = input.value || '';
                                textSpan.style.fontSize = '14px';
                                textSpan.style.lineHeight = '1.5';
                                textSpan.style.display = 'inline';
                                textSpan.style.border = 'none';
                                textSpan.style.background = 'transparent';
                                textSpan.style.padding = '0';
                                textSpan.style.margin = '0';
                                input.parentNode.replaceChild(textSpan, input);
                            }
                        });

                        // Adjust point-row layout for plain text display
                        const pointRows = element.querySelectorAll('.point-row');
                        pointRows.forEach(row => {
                            row.style.display = 'block';
                            row.style.whiteSpace = 'nowrap';
                            row.style.alignItems = 'unset';
                            const bullet = row.querySelector('.bullet');
                            if (bullet) {
                                // Replace bullet div with span to ensure inline behavior in PDF
                                const bulletSpan = document.createElement('span');
                                bulletSpan.textContent = bullet.textContent;
                                bulletSpan.style.display = 'inline';
                                bulletSpan.style.marginRight = '10px';
                                bulletSpan.style.marginTop = '0';
                                bulletSpan.style.minWidth = '20px';
                                bulletSpan.style.color = 'var(--primary)';
                                bulletSpan.style.whiteSpace = 'nowrap';
                                bullet.parentNode.replaceChild(bulletSpan, bullet);
                            }
                            const textElement = row.querySelector('span, div');
                            if (textElement) {
                                textElement.style.display = 'inline';
                                textElement.style.whiteSpace = 'nowrap';
                            }
                        });

                        // Remove borders and backgrounds from point-input containers
                        const pointInputs = element.querySelectorAll('.point-input');
                        pointInputs.forEach(input => {
                            input.style.border = 'none';
                            input.style.background = 'transparent';
                            input.style.padding = '2px 5px';
                        });

                        // Ensure proper spacing for PDF
                        const sections = element.querySelectorAll('.section');
                        sections.forEach(section => {
                            section.style.pageBreakInside = 'avoid';
                            section.style.marginBottom = '20px';
                        });

                        // Handle section toggles for PDF exclusion
                        const checkboxes = ['include-ongoing', 'include-testing', 'include-issues', 'include-team-summary', 'include-plan'];
                        checkboxes.forEach(id => {
                            const checkbox = element.querySelector('#' + id);
                            if (checkbox && !checkbox.checked) {
                                const sectionId = id.replace('include-', '') + '-section';
                                const section = element.querySelector('#' + sectionId);
                                if (section) section.style.display = 'none';
                            }
                        });

                        // Hide include-toggle labels in PDF
                        const toggles = element.querySelectorAll('.include-toggle');
                        toggles.forEach(toggle => toggle.style.display = 'none');
                    } else {
                        // Restore elements after PDF generation
                        // Reload the page to restore original state
                        location.reload();
                    }
                }

                // Function to print report
                function printReport() {
                    // Temporarily hide buttons and convert inputs to plain text
                    const originalDisplay = {
                        actions: document.querySelector('.form-actions').style.display,
                        addButtons: document.querySelectorAll('.add-point-btn'),
                        removeButtons: document.querySelectorAll('.remove-point')
                    };

                    // Hide interactive elements for printing
                    document.querySelector('.form-actions').style.display = 'none';
                    document.querySelectorAll('.add-point-btn').forEach(btn => btn.style.display = 'none');
                    document.querySelectorAll('.remove-point').forEach(btn => btn.style.display = 'none');

                    // Convert inputs and textareas to display text
                    const inputs = document.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        if (input.tagName === 'SELECT') {
                            // For dropdowns, show selected option text
                            const selectedOption = input.options[input.selectedIndex];
                            const textSpan = document.createElement('span');
                            textSpan.textContent = selectedOption ? selectedOption.textContent : '';
                            textSpan.style.fontSize = '14px';
                            textSpan.style.lineHeight = '1.5';
                            textSpan.style.display = 'block';
                            textSpan.style.marginBottom = '5px';
                            input.parentNode.replaceChild(textSpan, input);
                        } else if (input.tagName === 'TEXTAREA') {
                            // For textareas, show plain text
                            const textDiv = document.createElement('div');
                            textDiv.textContent = input.value || '';
                            textDiv.style.fontSize = '14px';
                            textDiv.style.lineHeight = '1.5';
                            textDiv.style.whiteSpace = 'pre-wrap';
                            textDiv.style.wordWrap = 'break-word';
                            textDiv.style.border = 'none';
                            textDiv.style.background = 'transparent';
                            textDiv.style.padding = '0';
                            textDiv.style.margin = '0';
                            input.parentNode.replaceChild(textDiv, input);
                        } else if (input.type === 'text' || input.type === 'email' || input.type === 'date') {
                            // For text inputs, show plain text
                            const textSpan = document.createElement('span');
                            textSpan.textContent = input.value || '';
                            textSpan.style.fontSize = '14px';
                            textSpan.style.lineHeight = '1.5';
                            textSpan.style.display = 'block';
                            textSpan.style.border = 'none';
                            textSpan.style.background = 'transparent';
                            textSpan.style.padding = '0';
                            textSpan.style.margin = '0';
                            input.parentNode.replaceChild(textSpan, input);
                        }
                    });

                    // Trigger print
                    window.print();

                    // Restore elements after printing by reloading
                    setTimeout(() => {
                        location.reload();
                    }, 100);
                }

                // Function to toggle section visibility
                function toggleSection(sectionId, containerId, checkboxId) {
                    const checkbox = document.getElementById(checkboxId);
                    const section = document.getElementById(sectionId);
                    const pointsContainer = document.getElementById(containerId);
                    const addButton = section.querySelector('.add-point-btn');

                    if (checkbox.checked) {
                        section.style.display = 'block';
                        pointsContainer.style.display = 'block';
                        addButton.style.display = 'flex';
                    } else {
                        section.style.display = 'none';
                    }
                }


            </script>
        </body>
@endsection