<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeCardController;
use App\Http\Controllers\ExpenseController;
Route::get('/', function () {
    return view('welcome');
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
        Route::put('sub-admins/{id}', [AdminController::class, 'updateSubAdmin'])->name('admin.sub-admins.update');
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
        Route::post('activities/{activity}/add-to-ratings/{employee}', [\App\Http\Controllers\ActivityController::class, 'addToRatings'])->name('activities.add-to-ratings');
        Route::post('activities/{activity}/reject-rating/{employee}', [\App\Http\Controllers\ActivityController::class, 'rejectRating'])->name('activities.reject-rating');

        // Attendance Management Routes
        Route::get('attendance/monthly/{employee?}', [AttendanceController::class, 'monthly'])->name('attendance.monthly');
        Route::get('attendance/show-monthly', [AttendanceController::class, 'showMonthly'])->name('attendance.showMonthly');
        Route::post('attendance/bulk-update', [AttendanceController::class, 'bulkUpdate'])->name('attendance.bulk-update');
        Route::get('attendance/report/{date?}', [AttendanceController::class, 'report'])->name('attendance.report');
        Route::resource('attendance', AttendanceController::class)->names([
            'index' => 'attendance.index',
            'create' => 'attendance.create',
            'store' => 'attendance.store',
            'show' => 'attendance.show',
            'edit' => 'attendance.edit',
            'update' => 'attendance.update',
            'destroy' => 'attendance.destroy',
        ]);

        // Salary Slips Management Routes
        Route::get('salary-slips/{salarySlip}/download-pdf', [\App\Http\Controllers\SalarySlipController::class, 'downloadPdf'])->name('salary-slips.download-pdf');
        Route::resource('salary-slips', \App\Http\Controllers\SalarySlipController::class)->names([
            'index' => 'salary-slips.index',
            'create' => 'salary-slips.create',
            'store' => 'salary-slips.store',
            'show' => 'salary-slips.show',
            'edit' => 'salary-slips.edit',
            'update' => 'salary-slips.update',
            'destroy' => 'salary-slips.destroy',
        ]);

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
        });
           
    });
});

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
    });
});