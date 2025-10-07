<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Assigned</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .content p {
            margin: 0 0 15px;
            font-size: 16px;
            line-height: 1.5;
        }
        .task-details {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .task-details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .task-details li {
            margin-bottom: 12px;
            font-size: 15px;
        }
        .task-details strong {
            color: #495057;
            display: inline-block;
            min-width: 120px;
            font-weight: 600;
        }
        .cta-button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            margin-top: 10px;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 13px;
            border-top: 1px solid #e0e0e0;
        }
        @media only screen and (max-width: 600px) {
            .container {
                border-radius: 0;
            }
            .header, .content, .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Task Assigned</h1>
        </div>
        <div class="content">
            <p>Dear {{ $employee->name }},</p>
            <p>You have been assigned a new task. Please review the details below:</p>
            <div class="task-details">
                <ul>
                    <li><strong>Task Name:</strong> {{ $task->task_name }}</li>
                    <li><strong>Description:</strong> {{ $task->description }}</li>
                    <li><strong>Start Date:</strong> {{ $task->start_date }}</li>
                    <li><strong>End Date:</strong> {{ $task->end_date }}</li>
                    <li><strong>Priority:</strong> {{ $task->priority }}</li>
                    <li><strong>Status:</strong> {{ $task->status }}</li>
                </ul>
            </div>
            <p>To view all your tasks, click the button below:</p>
            <a href="{{ url('/employee/tasks') }}" class="cta-button">View Tasks</a>
        </div>
        <div class="footer">
            <p>This is an automated message from OFFICE CRM. Please do not reply.</p>
        </div>
    </div>
</body>
</html>