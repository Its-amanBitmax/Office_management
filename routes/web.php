<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeCardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InterviewController;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    // Get dynamic logo and company name for welcome page
    $logo = '';
    $company_name = 'Office CRM'; // Default
    $admin = \App\Models\Admin::where('role', 'super_admin')->first() ?? \App\Models\Admin::first();
    if ($admin) {
        if ($admin->company_logo && \Illuminate\Support\Facades\Storage::disk('public')->exists('company_logos/' . $admin->company_logo)) {
            $logo = asset('storage/company_logos/' . $admin->company_logo);
        } else {
            // Use static logo
            $logo = asset('images/logo.png');
        }
        $company_name = $admin->company_name ?? 'Office CRM';
    }

    return view('welcome', compact('logo', 'company_name'));
});


Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy');




Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
      Route::get('/sync-office-ip', [AttendanceController::class, 'syncOfficeIp']);
 Route::post('evaluation-report/save-pdf/{id}', 
        [AdminController::class, 'saveEvaluationPdf']
    )->name('admin.evaluation-report.save-pdf');
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        Route::put('/password', [AdminController::class, 'updatePassword'])->name('admin.password.update');

        // Employee Management Routes
        Route::middleware('admin:employees')->group(function () {
            Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->names([
                'index' => 'employees.index',
                'create' => 'employees.create',
                'store' => 'employees.store',
                'show' => 'employees.show',
                'edit' => 'employees.edit',
                'update' => 'employees.update',
                'destroy' => 'employees.destroy',
            ]);
            Route::put('employees/{employee}/terminate', [\App\Http\Controllers\EmployeeController::class, 'terminate'])->name('employees.terminate');
            Route::put('employees/{employee}/resign', [\App\Http\Controllers\EmployeeController::class, 'resign'])->name('employees.resign');
            Route::get('employees/{employee}/card', [\App\Http\Controllers\EmployeeController::class, 'card'])->name('employees.card');
        });

        // Task Management Routes
        Route::middleware('admin:tasks')->group(function () {
            Route::resource('tasks', \App\Http\Controllers\TaskController::class)->names([
                'index' => 'tasks.index',
                'create' => 'tasks.create',
                'store' => 'tasks.store',
                'show' => 'tasks.show',
                'edit' => 'tasks.edit',
                'update' => 'tasks.update',
                'destroy' => 'tasks.destroy',
            ]);
        });


        
        // Admin Reports Routes
        Route::middleware('admin:reports')->group(function () {
            Route::get('reports', [\App\Http\Controllers\AdminReportController::class, 'index'])->name('admin.reports.index');
            Route::get('reports/{id}', [\App\Http\Controllers\AdminReportController::class, 'show'])->name('admin.reports.show');
            Route::put('reports/{id}', [\App\Http\Controllers\AdminReportController::class, 'update'])->name('admin.reports.update');
        });

        // Admin Performance Route
        Route::middleware('admin:performance')->get('performance', [AdminController::class, 'performance'])->name('admin.performance');
        Route::middleware('admin:performance')->get('evaluation-report', [AdminController::class, 'evaluationReport'])->name('admin.evaluation-report');
        Route::middleware('admin:performance')->get('evaluation-report/{id}', [AdminController::class, 'showEvaluationReport'])->name('admin.show-evaluation-report');
        Route::middleware('admin:performance')->get('evaluation-report/{id}/download-pdf', [AdminController::class, 'downloadEvaluationReportPdf'])->name('admin.evaluation-report.download-pdf');
        Route::middleware('admin:performance')->get('evaluation-report/{id}/data', [AdminController::class, 'getEvaluationReportData'])->name('admin.get-evaluation-report-data');
        Route::middleware('admin:performance')->get('add-evaluation-report', [AdminController::class, 'addEvaluationReport'])->name('admin.add-evaluation-report');
        Route::middleware('admin:performance')->post('store-evaluation-report', [AdminController::class, 'storeEvaluationReport'])->name('admin.store-evaluation-report');
        Route::middleware('admin:performance')->get('edit-evaluation-report/{id}', [AdminController::class, 'editEvaluationReport'])->name('admin.edit-evaluation-report');
        Route::middleware('admin:performance')->put('update-evaluation-report/{id}', [AdminController::class, 'updateEvaluationReport'])->name('admin.update-evaluation-report');
        Route::middleware('admin:performance')->delete('delete-evaluation-report/{id}', [AdminController::class, 'deleteEvaluationReport'])->name('admin.delete-evaluation-report');

        // Admin Logs Route
        Route::middleware('admin:logs')->get('logs', [AdminController::class, 'logs'])->name('admin.logs');

        // Admin Chatbot Route
        Route::middleware('admin:chatbot')->get('chatbot', [AdminController::class, 'chatbot'])->name('admin.chatbot');

        // Sub-Admin Management Routes
        Route::get('sub-admins', [AdminController::class, 'indexSubAdmins'])->name('admin.sub-admins.index');
        Route::get('sub-admins/create', [AdminController::class, 'createSubAdmin'])->name('admin.sub-admins.create');
        Route::post('sub-admins', [AdminController::class, 'storeSubAdmin'])->name('admin.sub-admins.store');
        Route::get('sub-admins/{id}', [AdminController::class, 'show'])->name('admin.sub-admins.show');
        Route::get('sub-admins/{id}/edit', [AdminController::class, 'editSubAdmin'])->name('admin.sub-admins.edit');
        Route::put('sub-admins/{id}', [AdminController::class, 'updateSubAdmin' ])->name('admin.sub-admins.update');
        Route::delete('sub-admins/{id}', [AdminController::class, 'deleteSubAdmin'])->name('admin.sub-admins.destroy');

        // Activities Routes
        Route::resource('activities', \App\Http\Controllers\ActivityController::class)->names([
            'index' => 'activities.index',
            'create' => 'activities.create',
            'store' => 'activities.store',
            'show' => 'activities.show',
            'edit' => 'activities.edit',
            'update' => 'activities.update',
            'destroy' => 'activities.destroy',
        ]);
        
            Route::middleware('admin:form')->group(function () {
            Route::resource('form', \App\Http\Controllers\FormController::class)->names([
                'index' => 'admin.form.index',
                'create' => 'admin.form.create',
                'store' => 'admin.form.store',
                'show' => 'admin.form.show',
                'edit' => 'admin.form.edit',
                'update' => 'admin.form.update',
                'destroy' => 'admin.form.destroy',
            ]);
            Route::get('form/api', [\App\Http\Controllers\FormController::class, 'api'])->name('admin.form.api');
            Route::get('form/trip', [\App\Http\Controllers\FormController::class, 'trip'])->name('admin.form.trip');
        });

        Route::post('activities/{activity}/add-to-ratings/{employee}', [\App\Http\Controllers\ActivityController::class, 'addToRatings'])->name('activities.add-to-ratings');
        Route::post('activities/{activity}/reject-rating/{employee}', [\App\Http\Controllers\ActivityController::class, 'rejectRating'])->name('activities.reject-rating');

        // Attendance Management Routes
        Route::get('attendance/monthly/{employee?}', [AttendanceController::class, 'monthly'])->name('attendance.monthly');
        Route::get('attendance/show-monthly', [AttendanceController::class, 'showMonthly'])->name('attendance.showMonthly');
        Route::get('attendance/export-monthly', [AttendanceController::class, 'exportMonthly'])->name('attendance.exportMonthly');
        Route::post('attendance/bulk-update', [AttendanceController::class, 'bulkUpdate'])->name('attendance.bulk-update');
        Route::get('attendance/report/{date?}', [AttendanceController::class, 'report'])->name('attendance.report');
        Route::get('attendance/export-today-pdf', [AttendanceController::class, 'exportTodayPdf'])->name('attendance.export-today-pdf');
        Route::resource('attendance', AttendanceController::class)->names([
            'index' => 'attendance.index',
            'create' => 'attendance.create',
            'store' => 'attendance.store',
            'show' => 'attendance.show',
            'edit' => 'attendance.edit',
            'update' => 'attendance.update',
            'destroy' => 'attendance.destroy',
        ]);
        Route::put(
    '/interviews/{id}/toggle-link-status',
    [InterviewController::class, 'toggleLinkStatus']
)->name('interviews.toggleLinkStatus');

        // Salary Slips Management Routes
        Route::get('salary-slips/{salarySlip}/download-pdf', [\App\Http\Controllers\SalarySlipController::class, 'downloadPdf'])->name('salary-slips.download-pdf');
        Route::get('salary-slips/template', [\App\Http\Controllers\SalarySlipController::class, 'template'])->name('salary-slips.template');
        Route::resource('salary-slips', \App\Http\Controllers\SalarySlipController::class)->names([
            'index' => 'salary-slips.index',
            'create' => 'salary-slips.create',
            'store' => 'salary-slips.store',
            'show' => 'salary-slips.show',
            'edit' => 'salary-slips.edit',
            'update' => 'salary-slips.update',
            'destroy' => 'salary-slips.destroy',
        ]);
        Route::post(
    'salary-slips/{salarySlip}/send-to-documents',
    [\App\Http\Controllers\SalarySlipController::class, 'sendToEmployeeDocuments']
)->name('salary-slips.send-to-documents');


        // Visitors Management Routes
        Route::resource('visitors', \App\Http\Controllers\VisitorController::class)->names([
            'index' => 'visitors.index',
            'create' => 'visitors.create',
            'store' => 'visitors.store',
            'show' => 'visitors.show',
            'edit' => 'visitors.edit',
            'update' => 'visitors.update',
            'destroy' => 'visitors.destroy',
        ]);
        Route::get('visitors/{visitor}/card', [\App\Http\Controllers\VisitorController::class, 'card'])->name('visitors.card');

        // Invited Visitors Management Routes
        Route::resource('invited-visitors', \App\Http\Controllers\InvitedVisitorController::class)->names([
            'index' => 'invited-visitors.index',
            'create' => 'invited-visitors.create',
            'store' => 'invited-visitors.store',
            'show' => 'invited-visitors.show',
            'edit' => 'invited-visitors.edit',
            'update' => 'invited-visitors.update',
            'destroy' => 'invited-visitors.destroy',
        ]);
        Route::get('invited-visitors/{invitedVisitor}/card', [\App\Http\Controllers\InvitedVisitorController::class, 'card'])->name('invited-visitors.card');
        Route::get('invited-visitors/{invitedVisitor}/invitation-pdf', [\App\Http\Controllers\InvitedVisitorController::class, 'invitationPdf'])->name('invited-visitors.invitation-pdf');

        // Stock Management Routes
        Route::resource('stock', \App\Http\Controllers\StockController::class)->parameters([
            'stock' => 'stockItem'
        ])->names([
            'index' => 'admin.stock.index',
            'create' => 'admin.stock.create',
            'store' => 'admin.stock.store',
            'show' => 'admin.stock.show',
            'edit' => 'admin.stock.edit',
            'update' => 'admin.stock.update',
            'destroy' => 'admin.stock.destroy',
        ]);
        Route::get('stock/assign/form', [\App\Http\Controllers\StockController::class, 'assignForm'])->name('admin.stock.assign.form');
        Route::post('stock/assign', [\App\Http\Controllers\StockController::class, 'assign'])->name('admin.stock.assign');
        Route::get('/admin/stock/all-assigned', [\App\Http\Controllers\StockController::class, 'allAssigned'])->name('admin.stock.all-assigned');
        Route::get('assigned-items/{assignedItem}/edit', [\App\Http\Controllers\StockController::class, 'editAssigned'])->name('admin.assigned-items.edit');
        Route::put('assigned-items/{assignedItem}', [\App\Http\Controllers\StockController::class, 'updateAssigned'])->name('admin.assigned-items.update');
        Route::delete('assigned-items/{assignedItem}', [\App\Http\Controllers\StockController::class, 'destroyAssigned'])->name('admin.assigned-items.destroy');
        Route::get('/employee-card/{employee?}', [EmployeeCardController::class, 'index'])->name('employee.card.index');
        Route::get('/employee-card/{employee}', [EmployeeCardController::class, 'show'])->name('employee.card.show');
        Route::get('/employee-card/{employee}/pdf', [EmployeeCardController::class, 'pdf'])->name('employee.card.pdf');

        // Expenses Management Routes
        Route::middleware('admin:expenses')->group(function () {
            Route::resource('expenses', \App\Http\Controllers\ExpenseController::class)->names([
                'index' => 'admin.expenses.index',
                'create' => 'admin.expenses.create',
                'store' => 'admin.expenses.store',
                'show' => 'admin.expenses.show',
                'edit' => 'admin.expenses.edit',
                'update' => 'admin.expenses.update',
                'destroy' => 'admin.expenses.destroy',
            ]);
            Route::post('expenses/update-budget', [\App\Http\Controllers\ExpenseController::class, 'updateBudget'])->name('admin.expenses.update-budget');
            Route::post('expenses/add-budget', [\App\Http\Controllers\ExpenseController::class, 'addBudget'])->name('admin.expenses.add-budget');
            Route::get('expenses/export/{month}/{year}', [\App\Http\Controllers\ExpenseController::class, 'export'])->name('admin.expenses.export');
        });

        // Leave Requests Management Routes
        Route::resource('leave-requests', \App\Http\Controllers\LeaveRequestController::class)->names([
            'index' => 'admin.leave-requests.index',
            'create' => 'admin.leave-requests.create',
            'store' => 'admin.leave-requests.store',
            'show' => 'admin.leave-requests.show',
            'edit' => 'admin.leave-requests.edit',
            'update' => 'admin.leave-requests.update',
            'destroy' => 'admin.leave-requests.destroy',
        ]);

        // Global Search Route
        Route::get('/search', [AdminController::class, 'search'])->name('admin.search');

        // Evaluation Assignments Route
        Route::post('/update-evaluation-assignments', [AdminController::class, 'updateEvaluationAssignments'])->name('admin.update-evaluation-assignments');

        // Interviews Management Routes
        Route::resource('interviews', \App\Http\Controllers\InterviewController::class)->names([
            'index' => 'admin.interviews.index',
            'create' => 'admin.interviews.create',
            'store' => 'admin.interviews.store',
            'show' => 'admin.interviews.show',
            'edit' => 'admin.interviews.edit',
            'update' => 'admin.interviews.update',
            'destroy' => 'admin.interviews.destroy',
        ]);
        Route::get('interviews/{interview}/room', [\App\Http\Controllers\InterviewController::class, 'showInterviewRoomAdmin'])->name('admin.interviews.room');

        // HR MIS Reports Management Routes
        Route::middleware('admin:hr-mis-reports')->group(function () {
            Route::resource('hr-mis-reports', \App\Http\Controllers\HrMisReportController::class)->names([
                'index' => 'hr-mis-reports.index',
                'create' => 'hr-mis-reports.create',
                'store' => 'hr-mis-reports.store',
                'show' => 'hr-mis-reports.show',
                'edit' => 'hr-mis-reports.edit',
                'update' => 'hr-mis-reports.update',
                'destroy' => 'hr-mis-reports.destroy',
            ]);
            Route::get('hr-mis-reports/{id}/download-pdf', [\App\Http\Controllers\HrMisReportController::class, 'downloadPdf'])->name('hr-mis-reports.download-pdf');
        });

        // Notifications Route
        Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index');
        Route::match(['GET', 'POST'], '/notifications/read/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead']);
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('admin.notifications.markAllRead');
        Route::get('/notifications/ajax', [\App\Http\Controllers\Admin\NotificationController::class, 'ajax'])->name('admin.notifications.ajax');
        Route::delete('notifications/{id}',
    [\App\Http\Controllers\Admin\NotificationController::class, 'destroy']
)->name('admin.notifications.destroy');

        // WhatsApp Bot Routes
        Route::middleware('admin:whatsapp')->group(function () {
            Route::get('/whatsapp', [\App\Http\Controllers\WhatsAppController::class, 'index'])->name('admin.whatsapp.index');
            Route::post('/whatsapp/send', [\App\Http\Controllers\WhatsAppController::class, 'sendMessage'])->name('admin.whatsapp.send');
            Route::post('/whatsapp/send-group', [\App\Http\Controllers\WhatsAppController::class, 'sendGroupMessage'])->name('admin.whatsapp.send-group');
            Route::post('/whatsapp/send-bulk', [\App\Http\Controllers\WhatsAppController::class, 'sendBulkMessage'])->name('admin.whatsapp.send-bulk');

            // Media sending routes
            Route::post('/whatsapp/send-media', [\App\Http\Controllers\WhatsAppController::class, 'sendMediaMessage'])->name('admin.whatsapp.send-media');
            Route::post('/whatsapp/send-bulk-media', [\App\Http\Controllers\WhatsAppController::class, 'sendBulkMediaMessage'])->name('admin.whatsapp.send-bulk-media');
            Route::post('/whatsapp/send-group-media', [\App\Http\Controllers\WhatsAppController::class, 'sendGroupMediaMessage'])->name('admin.whatsapp.send-group-media');

            // AJAX routes for auto-refresh
            Route::get('/whatsapp/status', [\App\Http\Controllers\WhatsAppController::class, 'getStatus'])->name('admin.whatsapp.status');
            Route::get('/whatsapp/qr-code', [\App\Http\Controllers\WhatsAppController::class, 'getQrCodeAjax'])->name('admin.whatsapp.qr-code');
            Route::get('/whatsapp/groups-data', [\App\Http\Controllers\WhatsAppController::class, 'getGroupsAjax'])->name('admin.whatsapp.groups-data');
            Route::post('/whatsapp/start-bot', [\App\Http\Controllers\WhatsAppController::class, 'startBot'])->name('admin.whatsapp.start-bot');
            Route::post('/whatsapp/delete-session', [\App\Http\Controllers\WhatsAppController::class, 'deleteSession'])->name('admin.whatsapp.delete-session');
        });

        // Leads Management Routes
        Route::resource('leads', \App\Http\Controllers\Admin\LeadsController::class)->names([
            'index' => 'admin.leads.index',
            'create' => 'admin.leads.create',
            'store' => 'admin.leads.store',
            'show' => 'admin.leads.show',
            'edit' => 'admin.leads.edit',
            'update' => 'admin.leads.update',
            'destroy' => 'admin.leads.destroy',
        ]);

        // Interactions Management Routes
        Route::resource('interactions', \App\Http\Controllers\Admin\InteractionsController::class)->names([
            'index' => 'admin.interactions.index',
            'create' => 'admin.interactions.create',
            'store' => 'admin.interactions.store',
            'show' => 'admin.interactions.show',
            'edit' => 'admin.interactions.edit',
            'update' => 'admin.interactions.update',
            'destroy' => 'admin.interactions.destroy',
        ]);

        // Proposals Management Routes
        Route::resource('proposals', \App\Http\Controllers\Admin\ProposalsController::class)->names([
            'index' => 'admin.proposals.index',
            'create' => 'admin.proposals.create',
            'store' => 'admin.proposals.store',
            'show' => 'admin.proposals.show',
            'edit' => 'admin.proposals.edit',
            'update' => 'admin.proposals.update',
            'destroy' => 'admin.proposals.destroy',
        ]);

        // Executives Management Routes
        Route::resource('executives', \App\Http\Controllers\Admin\ExecutiveController::class)->names([
            'index' => 'admin.executives.index',
            'show' => 'admin.executives.show',
        ]);

    });
});

// Interview Link Routes (Public - outside admin middleware)
Route::get('interview/start/{unique_link}', [\App\Http\Controllers\InterviewController::class, 'showInterviewRoom'])->name('interview.room');
Route::get('interview/{unique_link}', [\App\Http\Controllers\InterviewController::class, 'showInterviewLink'])->name('interview.link');
Route::post('interview/{unique_link}/verify', [\App\Http\Controllers\InterviewController::class, 'verifyCredentials'])->name('interview.verify');
Route::post('interview/{unique_link}/start', [\App\Http\Controllers\InterviewController::class, 'startInterview'])->name('interview.start');
Route::post('interview/log-error', [\App\Http\Controllers\InterviewController::class, 'logError'])->name('interview.log-error');
Route::post(
    'interview/{unique_link}/end',
    [\App\Http\Controllers\InterviewController::class, 'endInterview']
)->name('interview.end');

// WebRTC Signaling Routes (API routes without web middleware)
Route::post('interview/{unique_link}/signaling/send', [\App\Http\Controllers\InterviewController::class, 'sendSignalingMessage'])->name('interview.signaling.send')->withoutMiddleware(['web', 'csrf']);
Route::get('interview/{unique_link}/signaling/messages', [\App\Http\Controllers\InterviewController::class, 'getSignalingMessages'])->name('interview.signaling.messages')->withoutMiddleware(['web', 'csrf']);
Route::delete('interview/{unique_link}/signaling/clear', [\App\Http\Controllers\InterviewController::class, 'clearSignalingMessages'])->name('interview.signaling.clear')->withoutMiddleware(['web', 'csrf']);

Route::prefix('employee')->group(function () {
    Route::get('/login', [EmployeeController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/login', [EmployeeController::class, 'login']);
    Route::post('/logout', [EmployeeController::class, 'logout'])->name('employee.logout');

    Route::middleware('employee')->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
        Route::get('/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
        Route::put('/profile', [EmployeeController::class, 'updateProfile'])->name('employee.profile.update');

        // Employee Task Routes
        Route::get('/tasks', [EmployeeController::class, 'tasks'])->name('employee.tasks');
        Route::get('/tasks/{task}', [EmployeeController::class, 'showTask'])->name('employee.tasks.show');
        Route::get('/tasks/{task}/edit', [EmployeeController::class, 'editTask'])->name('employee.tasks.edit');
        Route::put('/tasks/{task}', [EmployeeController::class, 'updateTask'])->name('employee.tasks.update');
        Route::put('/tasks/{task}/progress', [EmployeeController::class, 'updateTaskProgress'])->name('employee.tasks.update-progress');

        // Employee Report Routes
        Route::get('/reports', [EmployeeController::class, 'reports'])->name('employee.reports');
        Route::get('/reports/create', [EmployeeController::class, 'createReport'])->name('employee.reports.create');
        Route::post('/reports', [EmployeeController::class, 'storeReport'])->name('employee.reports.store');
        Route::get('/reports/{report}', [EmployeeController::class, 'showReport'])->name('employee.reports.show');

        // Team Management Route
        Route::get('/team-management', [EmployeeController::class, 'teamManagement'])->name('employee.team.management');

        // Team Reports Routes
        Route::get('/team-reports', [EmployeeController::class, 'teamReports'])->name('employee.team-reports');
        Route::get('/team-reports/{report}', [EmployeeController::class, 'showTeamReport'])->name('employee.team-reports.show');
        Route::put('/team-reports/{report}', [EmployeeController::class, 'updateTeamReport'])->name('employee.team-reports.update');

        // Employee Activities Routes
        Route::get('/activities', [EmployeeController::class, 'activitiesIndex'])->name('employee.activities.index');
        Route::post('/activities/{activity}/start', [EmployeeController::class, 'startActivity'])->name('employee.activities.start');
        Route::post('/activities/{activity}/submit', [EmployeeController::class, 'submitActivity'])->name('employee.activities.submit');

        // Employee Assigned Items Route
        Route::get('/assigned-items', function() {
            $employee = auth('employee')->user();
            $assignedItems = \App\Models\AssignedItem::where('employee_id', $employee->id)->with('stockItem')->get();
            return view('employee.assigned-items', compact('assignedItems'));
        })->name('employee.assigned-items');

        // Employee Card PDF Route
        Route::get('/my-card/pdf', [EmployeeCardController::class, 'pdf'])->name('employee.card.pdf');

        // Employee Attendance Routes
        Route::get('/attendance', [EmployeeController::class, 'attendance'])->name('employee.attendance');
        Route::get('/attendance/show', [EmployeeController::class, 'showAttendance'])->name('employee.attendance.show');
        

        // Employee Leave Request Routes
        Route::get('/leave-requests', [\App\Http\Controllers\LeaveRequestController::class, 'employeeIndex'])->name('employee.leave-requests.index');
        Route::post('/leave-requests', [\App\Http\Controllers\LeaveRequestController::class, 'employeeStore'])->name('employee.leave-requests.store');
    });
            Route::get('/leave-requests/create', [\App\Http\Controllers\LeaveRequestController::class, 'employeeCreate'])->name('employee.leave-requests.create');
                    Route::get('/leave-requests/{leaveRequest}', [\App\Http\Controllers\LeaveRequestController::class, 'employeeShow'])->name('employee.leave-requests.show');

        // Employee Notifications Routes
        Route::middleware('employee')->group(function () {
            Route::get('/notifications', function () {
                $employee = auth('employee')->user();
                if (!$employee) {
                    abort(403);
                }
                $notifications = \App\Models\Notification::where('employee_id', $employee->id)
                    ->latest()
                    ->paginate(5);
                return view('employee.notifications.index', compact('notifications'));
            })->name('employee.notifications.index');

            Route::post('/notifications/read/{id}', function ($id) {
                $employee = auth('employee')->user();
                if (!$employee) {
                    return response()->json(['success' => false], 401);
                }
                \App\Models\Notification::where('id', $id)
                    ->where('employee_id', $employee->id)
                    ->update(['is_read' => true]);
                return response()->json(['success' => true]);
            });

            Route::post('/notifications/read-all', function () {
                \App\Models\Notification::where('employee_id', auth('employee')->id())
                    ->update(['is_read' => true]);
                return response()->json(['success' => true]);
            })->name('employee.notifications.readAll');
        });

        // AJAX route outside middleware to avoid redirect to HTML
        Route::get('/notifications/ajax', function () {
            $employee = auth('employee')->user();
            if (!$employee) {
                return response()->json([
                    'unread_count' => 0,
                    'notifications' => []
                ]);
            }
            $unreadCount = \App\Models\Notification::where('employee_id', $employee->id)
                ->where('is_read', false)
                ->count();
            $notifications = \App\Models\Notification::where('employee_id', $employee->id)
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get(['id', 'title', 'message', 'created_at']);
            return response()->json([
                'unread_count' => $unreadCount,
                'notifications' => $notifications
            ]);
        })->name('employee.notifications.ajax');

        Route::middleware(['auth:employee'])->group(function () {
    Route::get('attendance/mark', [AttendanceController::class, 'mark'])
        ->name('employee.attendance.mark');

    Route::post('attendance/submit', [AttendanceController::class, 'submit'])
        ->name('employee.attendance.submit');
});

});
