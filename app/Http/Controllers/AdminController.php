<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admin;
use App\Models\PerformanceReport;
use App\Models\QualityMetric;
use App\Models\SoftSkill;
use App\Models\OverallEvaluation;
use App\Traits\Loggable;

class AdminController extends Controller
{
    use Loggable;

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            // Log login activity
            $admin = Auth::guard('admin')->user();
            $this->logActivity('login', null, null, "Admin {$admin->name} logged in");

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to view dashboard
        if (!$admin->hasPermission('Dashboard')) {
            return redirect()->route('admin.login')->with('error', 'You do not have permission to access the dashboard.');
        }

        // Fetch dynamic stats (only show data for modules admin has access to)
        $totalUsers = $admin->hasPermission('employees') ? \App\Models\Employee::count() : 0;
        $activeTasks = $admin->hasPermission('tasks') ? \App\Models\Task::where('status', 'active')->count() : 0;
        $incompleteTasks = $admin->hasPermission('tasks') ? \App\Models\Task::where('status', '!=', 'completed')->count() : 0;
        $pendingReviews = $admin->hasPermission('reports') ? \App\Models\Report::where('admin_status', 'pending')->count() : 0;
        $totalSalaryExpenses = $admin->hasPermission('employees') ? \App\Models\Employee::sum(DB::raw('COALESCE(basic_salary, 0) + COALESCE(hra, 0) + COALESCE(conveyance, 0) + COALESCE(medical, 0)')) : 0;
        $systemAlerts = 0; // Placeholder for system alerts, can be implemented later if needed

        $tasks = $admin->hasPermission('tasks') ? \App\Models\Task::with(['assignedEmployee', 'teamLead'])->paginate(10) : collect();

        $recentEmployees = $admin->hasPermission('employees') ? \App\Models\Employee::orderBy('created_at', 'desc')->take(5)->get() : collect();

        return view('admin.dashboard', compact('admin', 'tasks', 'totalUsers', 'activeTasks', 'incompleteTasks', 'pendingReviews', 'totalSalaryExpenses', 'systemAlerts', 'recentEmployees'));
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'company_name' => 'nullable|string|max:255',
            // 'dark_mode' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'company_name' => $request->company_name,
            // 'dark_mode' => $request->dark_mode ?? false,
        ];

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($admin->profile_image && Storage::exists('public/profile_images/' . $admin->profile_image)) {
                Storage::delete('public/profile_images/' . $admin->profile_image);
            }

            // Store new image
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->storeAs('public/profile_images', $imageName);
            $data['profile_image'] = $imageName;
        }

        if ($request->hasFile('company_logo')) {
            // Delete old company logo if exists
            if ($admin->company_logo && Storage::exists('public/company_logos/' . $admin->company_logo)) {
                Storage::delete('public/company_logos/' . $admin->company_logo);
            }

            // Store new company logo
            $logoName = time() . '.' . $request->company_logo->extension();
            $request->company_logo->storeAs('public/company_logos', $logoName);
            $data['company_logo'] = $logoName;
        }

        $admin->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')->with('success', 'Password updated successfully!');
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Log logout activity before logging out
        if ($admin) {
            $this->logActivity('logout', null, null, "Admin {$admin->name} logged out");
        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }

    // Sub-Admin Management Methods
    public function indexSubAdmins()
    {
        $subAdmins = Admin::where('role', 'sub_admin')->paginate(10);
        return view('admin.sub-admins.index', compact('subAdmins'));
    }

    public function createSubAdmin()
    {
        $modules = [
            'Dashboard' => 'Dashboard',
            'employees' => 'Employees',
            'tasks' => 'Tasks',
            'activities' => 'Activities',
            'Employee Card' => 'Employee Card',
            'Assigned Items' => 'Assigned Items',
            'reports' => 'Reports',
            'attendance' => 'Attendance',
            'leave-requests' => 'Leave Requests',
            'salary-slips' => 'Salary Slips',
            'visitors' => 'Visitors',
            'invited-visitors' => 'Invited Visitors',
            'stock' => 'Stock Management',
            'performance' => 'Performance',
            'evaluation-report' => 'Evaluation Report',
            'expenses' => 'Expenses',
            'settings' => 'Settings',
            'logs' => 'Logs',
        ];

        return view('admin.sub-admins.create', compact('modules'));
    }

    public function storeSubAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'permissions' => 'array',
        ]);

        $permissions = $request->permissions ?? [];

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'bio' => $request->bio,
            'role' => 'sub_admin',
            'permissions' => $permissions,
        ]);

        return redirect()->route('admin.sub-admins.index')->with('success', 'Sub-admin created successfully!');
    }

    public function editSubAdmin($id)
    {
        $subAdmin = Admin::findOrFail($id);
        $modules = [
            'Dashboard' => 'Dashboard',
            'employees' => 'Employees',
            'tasks' => 'Tasks',
            'activities' => 'Activities',
            'Employee Card' => 'Employee Card',
            'Assigned Items' => 'Assigned Items',
            'reports' => 'Reports',
            'attendance' => 'Attendance',
            'leave-requests' => 'Leave Requests',
            'salary-slips' => 'Salary Slips',
            'visitors' => 'Visitors',
            'invited-visitors' => 'Invited Visitors',
            'stock' => 'Stock Management',
            'performance' => 'Performance',
            'evaluation-report' => 'Evaluation Report',
            'expenses' => 'Expenses',
            'settings' => 'Settings',
            'logs' => 'Logs',
        ];

        return view('admin.sub-admins.edit', compact('subAdmin', 'modules'));
    }

    public function updateSubAdmin(Request $request, $id)
    {
        $subAdmin = \App\Models\Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($subAdmin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'permissions' => 'array',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'permissions' => $request->permissions ?? [],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $subAdmin->update($data);

        return redirect()->route('admin.sub-admins.index')->with('success', 'Sub-admin updated successfully!');
    }

    public function deleteSubAdmin($id)
    {
        $subAdmin = Admin::findOrFail($id);
        $subAdmin->delete();

        return redirect()->route('admin.sub-admins.index')->with('success', 'Sub-admin deleted successfully!');
    }

    public function show($id)
    {
        $subAdmin = Admin::findOrFail($id);
        $modules = [
            'Dashboard' => 'Dashboard',
            'employees' => 'Employees',
            'tasks' => 'Tasks',
            'activities' => 'Activities',
            'Employee Card' => 'Employee Card',
            'Assigned Items' => 'Assigned Items',
            'reports' => 'Reports',
            'attendance' => 'Attendance',
            'leave-requests' => 'Leave Requests',
            'salary-slips' => 'Salary Slips',
            'visitors' => 'Visitors',
            'invited-visitors' => 'Invited Visitors',
            'stock' => 'Stock Management',
            'performance' => 'Performance',
            'evaluation-report' => 'Evaluation Report',
            'settings' => 'Settings',
            'logs' => 'Logs',
        ];

        return view('admin.sub-admins.show', compact('subAdmin', 'modules'));
    }

    public function performance(Request $request)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return $this->getPerformanceData($request);
        }

        $period = $request->get('period', 'monthly');
        $employeeId = $request->get('employee_id');
        $view = $request->get('view', 'dashboard'); // Default to dashboard view

        // Get date range based on period
        $now = now();
        if ($period === 'all') {
            $startDate = now()->startOfYear(); // dummy for view
            $endDate = now()->endOfYear();
        } else {
            switch ($period) {
                case 'daily':
                    $startDate = $now->startOfDay();
                    $endDate = $now->endOfDay();
                    break;
                case 'weekly':
                    $startDate = $now->startOfWeek();
                    $endDate = $now->endOfWeek();
                    break;
                case 'monthly':
                default:
                    $startDate = $now->startOfMonth();
                    $endDate = $now->endOfMonth();
                    break;
            }
        }

        // Get all employees for dropdown
        $employees = \App\Models\Employee::select('id', 'name', 'employee_code')->orderBy('name')->get();

        if ($view === 'by-report') {
            // Data based on evaluation reports
            $reportsQuery = \App\Models\PerformanceReport::with(['employee', 'overallEvaluation']);

            // Apply date filter if not 'all'
            if ($period !== 'all') {
                $reportsQuery->whereBetween('evaluation_date', [$startDate->toDateString(), $endDate->toDateString()]);
            }

            // Apply employee filter if specified
            if ($employeeId) {
                $reportsQuery->where('employee_id', $employeeId);
            }

            $reports = $reportsQuery->get();

            // Group by employee and calculate metrics based on reports
            $employeePerformance = [];
            $ratingDistribution = [];
            $totalRatings = 0;
            $averageRating = 0;
            $totalRatingSum = 0;

            foreach ($reports as $report) {
                if (!$report->overallEvaluation) continue;

                $empId = $report->employee_id;
                $overallRating = $report->overallEvaluation->overall_rating;

                if (!isset($employeePerformance[$empId])) {
                    $employeePerformance[$empId] = [
                        'employee' => $report->employee,
                        'total_ratings' => 0,
                        'average_rating' => 0,
                        'rating_sum' => 0,
                        'total_stars' => 0,
                        'rating_counts' => [],
                        'performance_score' => 0
                    ];
                }

                $employeePerformance[$empId]['total_ratings']++;
                $employeePerformance[$empId]['rating_sum'] += $overallRating;
                $employeePerformance[$empId]['total_stars'] += $overallRating;
                // Convert overall rating to star rating (1-5 scale)
                $stars = min(5, max(1, round($overallRating / 20))); // 0-100 to 1-5 scale
                if (!isset($employeePerformance[$empId]['rating_counts'][$stars])) {
                    $employeePerformance[$empId]['rating_counts'][$stars] = 0;
                }
                $employeePerformance[$empId]['rating_counts'][$stars]++;
                $employeePerformance[$empId]['average_rating'] = round($employeePerformance[$empId]['rating_sum'] / $employeePerformance[$empId]['total_ratings'], 1);

                // Calculate performance score (weighted average)
                $employeePerformance[$empId]['performance_score'] = $this->calculatePerformanceScore($employeePerformance[$empId]);

                // Use converted stars for ratingDistribution
                if (!isset($ratingDistribution[$stars])) {
                    $ratingDistribution[$stars] = 0;
                }
                $ratingDistribution[$stars]++;
                $totalRatings++;
                $totalRatingSum += $overallRating;
            }

            if ($totalRatings > 0) {
                $averageRating = round($totalRatingSum / $totalRatings, 1);
            }
        } else {
            // Original dashboard view based on ratings table
            $ratingsQuery = \App\Models\Rating::with('employee');

            if ($period !== 'all') {
                $ratingsQuery->whereBetween('rating_date', [$startDate->toDateString(), $endDate->toDateString()]);
            }

            // Apply employee filter if specified
            if ($employeeId) {
                $ratingsQuery->where('employee_id', $employeeId);
            }

            $ratings = $ratingsQuery->get();

            // Group by employee and calculate metrics based on ratings table
            $employeePerformance = [];
            $ratingDistribution = [];
            $totalRatings = 0;
            $averageRating = 0;
            $totalRatingSum = 0;

            foreach ($ratings as $rating) {
                $empId = $rating->employee_id;
                $stars = $rating->stars;

                if (!isset($employeePerformance[$empId])) {
                    $employeePerformance[$empId] = [
                        'employee' => $rating->employee,
                        'total_ratings' => 0,
                        'average_rating' => 0,
                        'rating_sum' => 0,
                        'total_stars' => 0,
                        'rating_counts' => [],
                        'performance_score' => 0
                    ];
                }

                $employeePerformance[$empId]['total_ratings']++;
                $employeePerformance[$empId]['rating_sum'] += $stars;
                $employeePerformance[$empId]['total_stars'] += $stars;
                // Use actual stars for rating_counts
                if (!isset($employeePerformance[$empId]['rating_counts'][$stars])) {
                    $employeePerformance[$empId]['rating_counts'][$stars] = 0;
                }
                $employeePerformance[$empId]['rating_counts'][$stars]++;
                $employeePerformance[$empId]['average_rating'] = round($employeePerformance[$empId]['rating_sum'] / $employeePerformance[$empId]['total_ratings'], 1);

                // Calculate performance score (weighted average)
                $employeePerformance[$empId]['performance_score'] = $this->calculatePerformanceScore($employeePerformance[$empId]);

                // Use actual stars for ratingDistribution
                if (!isset($ratingDistribution[$stars])) {
                    $ratingDistribution[$stars] = 0;
                }
                $ratingDistribution[$stars]++;
                $totalRatings++;
                $totalRatingSum += $stars;
            }

            if ($totalRatings > 0) {
                $averageRating = round($totalRatingSum / $totalRatings, 1);
            }
        }

        // Sort employees by performance score descending (better ranking)
        usort($employeePerformance, function($a, $b) {
            return $b['performance_score'] <=> $a['performance_score'];
        });

        return view('admin.performance', compact(
            'employeePerformance',
            'ratingDistribution',
            'totalRatings',
            'averageRating',
            'period',
            'startDate',
            'endDate',
            'employees',
            'view'
        ));
    }

    /**
     * Get performance data for AJAX requests
     */
    private function getPerformanceData(Request $request)
    {
        $period = $request->get('period', 'all');
        $employeeId = $request->get('employee_id');
        $view = $request->get('view', 'dashboard');

        // Get date range based on period
        $now = now();
        if ($period === 'all') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
        } else {
            switch ($period) {
                case 'daily':
                    $startDate = $now->startOfDay();
                    $endDate = $now->endOfDay();
                    break;
                case 'weekly':
                    $startDate = $now->startOfWeek();
                    $endDate = $now->endOfWeek();
                    break;
                case 'monthly':
                default:
                    $startDate = $now->startOfMonth();
                    $endDate = $now->endOfMonth();
                    break;
            }
        }

        if ($view === 'by-report') {
            // Data based on evaluation reports
            $reportsQuery = \App\Models\PerformanceReport::with(['employee', 'overallEvaluation']);

            if ($period !== 'all') {
                $reportsQuery->whereBetween('evaluation_date', [$startDate->toDateString(), $endDate->toDateString()]);
            }

            if ($employeeId) {
                $reportsQuery->where('employee_id', $employeeId);
            }

            $reports = $reportsQuery->get();

            $employeePerformance = [];
            $ratingDistribution = [];
            $totalRatings = 0;
            $averageRating = 0;
            $totalRatingSum = 0;

            foreach ($reports as $report) {
                if (!$report->overallEvaluation) continue;

                $empId = $report->employee_id;
                $overallRating = $report->overallEvaluation->overall_rating;

                if (!isset($employeePerformance[$empId])) {
                    $employeePerformance[$empId] = [
                        'employee' => $report->employee,
                        'total_ratings' => 0,
                        'average_rating' => 0,
                        'rating_sum' => 0,
                        'total_stars' => 0,
                        'rating_counts' => [],
                        'performance_score' => 0
                    ];
                }

                $employeePerformance[$empId]['total_ratings']++;
                $employeePerformance[$empId]['rating_sum'] += $overallRating;
                $employeePerformance[$empId]['total_stars'] += $overallRating;
                $stars = min(5, max(1, round($overallRating / 20)));
                if (!isset($employeePerformance[$empId]['rating_counts'][$stars])) {
                    $employeePerformance[$empId]['rating_counts'][$stars] = 0;
                }
                $employeePerformance[$empId]['rating_counts'][$stars]++;
                $employeePerformance[$empId]['average_rating'] = round($employeePerformance[$empId]['rating_sum'] / $employeePerformance[$empId]['total_ratings'], 1);
                $employeePerformance[$empId]['performance_score'] = $this->calculatePerformanceScore($employeePerformance[$empId]);

                if (!isset($ratingDistribution[$stars])) {
                    $ratingDistribution[$stars] = 0;
                }
                $ratingDistribution[$stars]++;
                $totalRatings++;
                $totalRatingSum += $overallRating;
            }

            if ($totalRatings > 0) {
                $averageRating = round($totalRatingSum / $totalRatings, 1);
            }
        } else {
            // Dashboard view based on ratings table
            $ratingsQuery = \App\Models\Rating::with('employee');

            if ($period !== 'all') {
                $ratingsQuery->whereBetween('rating_date', [$startDate->toDateString(), $endDate->toDateString()]);
            }

            if ($employeeId) {
                $ratingsQuery->where('employee_id', $employeeId);
            }

            $ratings = $ratingsQuery->get();

            $employeePerformance = [];
            $ratingDistribution = [];
            $totalRatings = 0;
            $averageRating = 0;
            $totalRatingSum = 0;

            foreach ($ratings as $rating) {
                $empId = $rating->employee_id;
                $stars = $rating->stars;

                if (!isset($employeePerformance[$empId])) {
                    $employeePerformance[$empId] = [
                        'employee' => $rating->employee,
                        'total_ratings' => 0,
                        'average_rating' => 0,
                        'rating_sum' => 0,
                        'total_stars' => 0,
                        'rating_counts' => [],
                        'performance_score' => 0
                    ];
                }

                $employeePerformance[$empId]['total_ratings']++;
                $employeePerformance[$empId]['rating_sum'] += $stars;
                $employeePerformance[$empId]['total_stars'] += $stars;
                if (!isset($employeePerformance[$empId]['rating_counts'][$stars])) {
                    $employeePerformance[$empId]['rating_counts'][$stars] = 0;
                }
                $employeePerformance[$empId]['rating_counts'][$stars]++;
                $employeePerformance[$empId]['average_rating'] = round($employeePerformance[$empId]['rating_sum'] / $employeePerformance[$empId]['total_ratings'], 1);
                $employeePerformance[$empId]['performance_score'] = $this->calculatePerformanceScore($employeePerformance[$empId]);

                if (!isset($ratingDistribution[$stars])) {
                    $ratingDistribution[$stars] = 0;
                }
                $ratingDistribution[$stars]++;
                $totalRatings++;
                $totalRatingSum += $stars;
            }

            if ($totalRatings > 0) {
                $averageRating = round($totalRatingSum / $totalRatings, 1);
            }
        }

        // Sort employees by performance score descending
        usort($employeePerformance, function($a, $b) {
            return $b['performance_score'] <=> $a['performance_score'];
        });

        return response()->json([
            'totalRatings' => $totalRatings,
            'averageRating' => $averageRating,
            'ratingDistribution' => $ratingDistribution,
            'employeePerformance' => array_values($employeePerformance)
        ]);
    }

    /**
     * Calculate performance score based on ratings
     * Higher score = better performance
     */
    private function calculatePerformanceScore($employeeData)
    {
        $avgRating = $employeeData['average_rating'];
        $totalRatings = $employeeData['total_ratings'];

        // Base score from average rating (0-5 points)
        $baseScore = $avgRating;

        // Bonus for consistency (more ratings = more reliable data)
        $consistencyBonus = min($totalRatings * 0.1, 1.0); // Max 1.0 bonus

        // Bonus for high ratings (5-star ratings get extra points)
        $highRatingBonus = (isset($employeeData['rating_counts'][5]) ? $employeeData['rating_counts'][5] : 0) / max($totalRatings, 1) * 0.5;

        return round($baseScore + $consistencyBonus + $highRatingBonus, 1);
    }

    public function evaluationReport(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to view evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view evaluation reports.');
        }

        // Get selected month, default to current
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $monthStart = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        // Generate weeks for the month
        $weeks = [];
        $current = $monthStart->copy()->startOfWeek(\Carbon\Carbon::MONDAY); // Start from Monday
        $weekNumber = 1;

        while ($current->lte($monthEnd)) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

            // Ensure week end doesn't go beyond month end
            if ($weekEnd->gt($monthEnd)) {
                $weekEnd = $monthEnd->copy();
            }

            $weeks[] = [
                'title' => "Week {$weekNumber}: " . $weekStart->format('M d') . ' - ' . $weekEnd->format('M d'),
                'start_date' => $weekStart->format('Y-m-d'),
                'end_date' => $weekEnd->format('Y-m-d'),
            ];

            $current->addWeek();
            $weekNumber++;
        }

        // Month card
        $monthCard = [
            'title' => $monthStart->format('F Y'),
            'start_date' => $monthStart->format('Y-m-d'),
            'end_date' => $monthEnd->format('Y-m-d'),
        ];

        // Fetch existing reports for each period
        $existingReports = [];

        // For each week
        foreach ($weeks as $week) {
            $key = $week['start_date'] . '-' . $week['end_date'];
            $existingReports[$key] = PerformanceReport::with('employee')
                ->where('review_from', $week['start_date'])
                ->where('review_to', $week['end_date'])
                ->get();
        }

        // For the month
        $monthKey = $monthCard['start_date'] . '-' . $monthCard['end_date'];
        $existingReports[$monthKey] = PerformanceReport::with('employee')
            ->where('review_from', $monthCard['start_date'])
            ->where('review_to', $monthCard['end_date'])
            ->get();

        // Generate month options for selector (last 12 months)
        $monthOptions = [];
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $monthOptions[$date->format('Y-m')] = $date->format('F Y');
        }

        return view('admin.evaluation-report', compact('weeks', 'monthCard', 'selectedMonth', 'monthOptions', 'existingReports'));
    }

    public function addEvaluationReport(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to add evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to add evaluation reports.');
        }

        // Get all employees for the dropdown
        $employees = \App\Models\Employee::select('id', 'name', 'employee_code')->orderBy('name')->get();

        // Get pre-filled dates from query parameters
        $reviewFrom = $request->get('review_from');
        $reviewTo = $request->get('review_to');

        return view('admin.add-evaluation-report', compact('employees', 'reviewFrom', 'reviewTo'));
    }

    public function storeEvaluationReport(Request $request)
    {
        // Debug: Log that the method was called
        \Log::info('storeEvaluationReport called', $request->all());

        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to add evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to add evaluation reports.');
        }

        $request->validate([
            'employee_name' => 'required|string',
            'designation' => 'required|string',
            'department' => 'required|string',
            'reporting_manager' => 'required|string',
            'review_from' => 'required|date',
            'review_to' => 'required|date',
            'evaluation_date' => 'required|date',
            'project_delivery' => 'nullable|string',
            'code_quality' => 'nullable|string',
            'performance' => 'nullable|string',
            'task_completion' => 'nullable|string',
            'innovation' => 'nullable|string',
            'teamwork' => 'nullable|string',
            'communication' => 'nullable|string',
            'attendance' => 'nullable|string',
            'code_efficiency' => 'nullable|integer|min:1|max:5',
            'uiux' => 'nullable|integer|min:1|max:5',
            'debugging' => 'nullable|integer|min:1|max:5',
            'version_control' => 'nullable|integer|min:1|max:5',
            'documentation' => 'nullable|integer|min:1|max:5',
            'professionalism' => 'nullable|integer|min:1|max:5',
            'team_collaboration' => 'nullable|integer|min:1|max:5',
            'learning' => 'nullable|integer|min:1|max:5',
            'initiative' => 'nullable|integer|min:1|max:5',
            'time_management' => 'nullable|integer|min:1|max:5',
            'technical_skills' => 'nullable|numeric|min:0|max:40',
            'task_delivery' => 'nullable|numeric|min:0|max:25',
            'quality_work' => 'nullable|numeric|min:0|max:15',
            'communication_score' => 'nullable|numeric|min:0|max:10',
            'teamwork_score' => 'nullable|numeric|min:0|max:10',
            'overall_rating' => 'nullable|numeric|min:0|max:100',
            'performance_grade' => 'required|string',
            'manager_final_feedback' => 'nullable|string',
        ]);

        // Extract employee ID from the employee_name field (format: "E101 - Aman Singh")
        $employeeNameParts = explode(' - ', $request->employee_name);
        $employeeCode = $employeeNameParts[0];

        // Find the employee by employee_code to get the actual ID
        $employee = \App\Models\Employee::where('employee_code', $employeeCode)->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found with code: ' . $employeeCode);
        }

        // Create the main performance report
        try {
            $performanceReport = PerformanceReport::create([
                'employee_id' => $employee->id,
                'designation' => $request->designation,
                'reporting_manager' => $request->reporting_manager,
                'review_from' => $request->review_from,
                'review_to' => $request->review_to,
                'evaluation_date' => $request->evaluation_date,
                'project_delivery' => $request->project_delivery,
                'code_quality' => $request->code_quality,
                'system_performance' => $request->performance,
                'task_completion' => $request->task_completion,
                'innovation' => $request->innovation,
                'teamwork' => $request->teamwork,
                'communication' => $request->communication,
                'attendance' => $request->attendance,
                'manager_feedback' => $request->manager_final_feedback,
            ]);
            \Log::info('PerformanceReport created', ['id' => $performanceReport->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to create PerformanceReport', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to save performance report: ' . $e->getMessage());
        }

        // Create quality metrics
        try {
            QualityMetric::create([
                'report_id' => $performanceReport->id,
                'code_efficiency' => $request->code_efficiency,
                'uiux' => $request->uiux,
                'debugging' => $request->debugging,
                'version_control' => $request->version_control,
                'documentation' => $request->documentation,
            ]);
            \Log::info('QualityMetric created', ['report_id' => $performanceReport->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to create QualityMetric', ['error' => $e->getMessage()]);
        }

        // Create soft skills
        try {
            SoftSkill::create([
                'report_id' => $performanceReport->id,
                'professionalism' => $request->professionalism,
                'team_collaboration' => $request->team_collaboration,
                'learning_adaptability' => $request->learning,
                'initiative_ownership' => $request->initiative,
                'time_management' => $request->time_management,
            ]);
            \Log::info('SoftSkill created', ['report_id' => $performanceReport->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to create SoftSkill', ['error' => $e->getMessage()]);
        }

        // Create overall evaluation
        try {
            OverallEvaluation::create([
                'report_id' => $performanceReport->id,
                'technical_skills_score' => $request->technical_skills,
                'task_delivery_score' => $request->task_delivery,
                'quality_of_work_score' => $request->quality_work,
                'communication_score' => $request->communication_score,
                'teamwork_score' => $request->teamwork_score,
                'overall_rating' => $request->overall_rating,
                'performance_grade' => $request->performance_grade,
            ]);
            \Log::info('OverallEvaluation created', ['report_id' => $performanceReport->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to create OverallEvaluation', ['error' => $e->getMessage()]);
        }

        \Log::info('Evaluation report created successfully', ['report_id' => $performanceReport->id]);

        return redirect()->route('admin.evaluation-report')->with('success', 'Evaluation report submitted successfully!');
    }

    public function editEvaluationReport($id)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to edit evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to edit evaluation reports.');
        }

        $report = PerformanceReport::with(['employee', 'qualityMetrics', 'softSkills', 'overallEvaluation'])->findOrFail($id);

        // Get all employees for the dropdown
        $employees = \App\Models\Employee::select('id', 'name', 'employee_code')->orderBy('name')->get();

        return view('admin.edit-evaluation-report', compact('report', 'employees'));
    }

    public function updateEvaluationReport(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to update evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to update evaluation reports.');
        }

        $request->validate([
            'employee_name' => 'required|string',
            'designation' => 'required|string',
            'department' => 'required|string',
            'reporting_manager' => 'required|string',
            'review_from' => 'required|date',
            'review_to' => 'required|date',
            'evaluation_date' => 'required|date',
            'project_delivery' => 'nullable|string',
            'code_quality' => 'nullable|string',
            'performance' => 'nullable|string',
            'task_completion' => 'nullable|string',
            'innovation' => 'nullable|string',
            'teamwork' => 'nullable|string',
            'communication' => 'nullable|string',
            'attendance' => 'nullable|string',
            'code_efficiency' => 'nullable|integer|min:1|max:5',
            'uiux' => 'nullable|integer|min:1|max:5',
            'debugging' => 'nullable|integer|min:1|max:5',
            'version_control' => 'nullable|integer|min:1|max:5',
            'documentation' => 'nullable|integer|min:1|max:5',
            'professionalism' => 'nullable|integer|min:1|max:5',
            'team_collaboration' => 'nullable|integer|min:1|max:5',
            'learning' => 'nullable|integer|min:1|max:5',
            'initiative' => 'nullable|integer|min:1|max:5',
            'time_management' => 'nullable|integer|min:1|max:5',
            'technical_skills' => 'nullable|numeric|min:0|max:40',
            'task_delivery' => 'nullable|numeric|min:0|max:25',
            'quality_work' => 'nullable|numeric|min:0|max:15',
            'communication_score' => 'nullable|numeric|min:0|max:10',
            'teamwork_score' => 'nullable|numeric|min:0|max:10',
            'overall_rating' => 'nullable|numeric|min:0|max:100',
            'performance_grade' => 'required|string',
            'manager_final_feedback' => 'nullable|string',
        ]);

        $report = PerformanceReport::findOrFail($id);

        // Extract employee ID from the employee_name field (format: "E101 - Aman Singh")
        $employeeNameParts = explode(' - ', $request->employee_name);
        $employeeCode = $employeeNameParts[0];

        // Find the employee by employee_code to get the actual ID
        $employee = \App\Models\Employee::where('employee_code', $employeeCode)->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found with code: ' . $employeeCode);
        }

        // Update the main performance report
        $report->update([
            'employee_id' => $employee->id,
            'designation' => $request->designation,
            'reporting_manager' => $request->reporting_manager,
            'review_from' => $request->review_from,
            'review_to' => $request->review_to,
            'evaluation_date' => $request->evaluation_date,
            'project_delivery' => $request->project_delivery,
            'code_quality' => $request->code_quality,
            'system_performance' => $request->performance,
            'task_completion' => $request->task_completion,
            'innovation' => $request->innovation,
            'teamwork' => $request->teamwork,
            'communication' => $request->communication,
            'attendance' => $request->attendance,
            'manager_feedback' => $request->manager_final_feedback,
        ]);

        // Update or create quality metrics
        if ($report->qualityMetrics) {
            $report->qualityMetrics->update([
                'code_efficiency' => $request->code_efficiency,
                'uiux' => $request->uiux,
                'debugging' => $request->debugging,
                'version_control' => $request->version_control,
                'documentation' => $request->documentation,
            ]);
        } else {
            QualityMetric::create([
                'report_id' => $report->id,
                'code_efficiency' => $request->code_efficiency,
                'uiux' => $request->uiux,
                'debugging' => $request->debugging,
                'version_control' => $request->version_control,
                'documentation' => $request->documentation,
            ]);
        }

        // Update or create soft skills
        if ($report->softSkills) {
            $report->softSkills->update([
                'professionalism' => $request->professionalism,
                'team_collaboration' => $request->team_collaboration,
                'learning_adaptability' => $request->learning,
                'initiative_ownership' => $request->initiative,
                'time_management' => $request->time_management,
            ]);
        } else {
            SoftSkill::create([
                'report_id' => $report->id,
                'professionalism' => $request->professionalism,
                'team_collaboration' => $request->team_collaboration,
                'learning_adaptability' => $request->learning,
                'initiative_ownership' => $request->initiative,
                'time_management' => $request->time_management,
            ]);
        }

        // Update or create overall evaluation
        if ($report->overallEvaluation) {
            $report->overallEvaluation->update([
                'technical_skills_score' => $request->technical_skills,
                'task_delivery_score' => $request->task_delivery,
                'quality_of_work_score' => $request->quality_work,
                'communication_score' => $request->communication_score,
                'teamwork_score' => $request->teamwork_score,
                'overall_rating' => $request->overall_rating,
                'performance_grade' => $request->performance_grade,
            ]);
        } else {
            OverallEvaluation::create([
                'report_id' => $report->id,
                'technical_skills_score' => $request->technical_skills,
                'task_delivery_score' => $request->task_delivery,
                'quality_of_work_score' => $request->quality_work,
                'communication_score' => $request->communication_score,
                'teamwork_score' => $request->teamwork_score,
                'overall_rating' => $request->overall_rating,
                'performance_grade' => $request->performance_grade,
            ]);
        }

        return redirect()->route('admin.evaluation-report')->with('success', 'Evaluation report updated successfully!');
    }

    public function showEvaluationReport($id)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to view evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view evaluation reports.');
        }

        $report = PerformanceReport::with(['employee', 'qualityMetrics', 'softSkills', 'overallEvaluation'])
            ->findOrFail($id);

        return view('admin.show-evaluation-report', compact('report'));
    }

    public function getEvaluationReportData($id)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to view evaluation reports
        if (!$admin->hasPermission('performance')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $report = PerformanceReport::with(['employee', 'qualityMetrics', 'softSkills', 'overallEvaluation'])
            ->findOrFail($id);

        return response()->json([
            'report' => $report,
            'employee' => $report->employee,
            'qualityMetrics' => $report->qualityMetrics,
            'softSkills' => $report->softSkills,
            'overallEvaluation' => $report->overallEvaluation
        ]);
    }

    public function deleteEvaluationReport($id)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to delete evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to delete evaluation reports.');
        }

        $report = PerformanceReport::findOrFail($id);

        // Delete related records first
        $report->qualityMetrics()->delete();
        $report->softSkills()->delete();
        $report->overallEvaluation()->delete();

        // Delete the main report
        $report->delete();

        return redirect()->route('admin.evaluation-report')->with('success', 'Evaluation report deleted successfully!');
    }

    public function downloadEvaluationReportPdf($id)
    {
        $admin = Auth::guard('admin')->user();

        // Check if admin has permission to view evaluation reports
        if (!$admin->hasPermission('performance')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to download evaluation reports.');
        }

        $report = PerformanceReport::with(['employee', 'qualityMetrics', 'softSkills', 'overallEvaluation'])
            ->findOrFail($id);

        // Get dynamic logo and company name from admin table
        $logo = '';
        if ($admin->company_logo && Storage::disk('public')->exists('company_logos/' . $admin->company_logo)) {
            $imagePath = storage_path('app/public/company_logos/' . $admin->company_logo);
            if (file_exists($imagePath)) {
                $imageData = base64_encode(file_get_contents($imagePath));
                $extension = pathinfo($admin->company_logo, PATHINFO_EXTENSION);
                $logo = 'data:image/' . $extension . ';base64,' . $imageData;
            }
        } else {
            // Use static logo
            $staticLogoPath = public_path('images/logo.png');
            if (file_exists($staticLogoPath)) {
                $imageData = base64_encode(file_get_contents($staticLogoPath));
                $logo = 'data:image/png;base64,' . $imageData;
            }
        }
        $company_name = $admin->company_name ?? 'Bitmax Group';

        $pdf = Pdf::loadView('admin.evaluation-report-pdf', compact('report', 'logo', 'company_name'));

        $filename = 'evaluation-report-' . $report->employee->name . '-' . $report->id . '.pdf';

        return $pdf->download($filename);
    }

public function logs()
{
    $admin = Auth::guard('admin')->user();

    // Check if admin has permission to view logs
    if (!$admin->hasPermission('logs')) {
        return redirect()->route('admin.dashboard')
            ->with('error', 'You do not have permission to view logs');
    }

    $logs = \App\Models\ActivityLog::with('user')
        ->whereHasMorph('user', [\App\Models\Admin::class], function ($query) {
            $query->where('role', 'sub_admin');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('admin.logs', compact('admin', 'logs'));
}

public function search(Request $request)
{
    $query = $request->get('q');
    if (!$query) {
        return response()->json([]);
    }

    $results = [];

    try {
        // Search Employees
        $employees = \App\Models\Employee::where('name', 'like', "%{$query}%")
            ->orWhere('employee_code', 'like', "%{$query}%")
            ->limit(5)
            ->get();
        foreach ($employees as $emp) {
            $results[] = [
                'name' => $emp->name . ' (' . $emp->employee_code . ')',
                'module' => 'Employee',
                'url' => route('employees.show', $emp->id)
            ];
        }

        // Search Tasks
        $tasks = \App\Models\Task::where('task_name', 'like', "%{$query}%")
            ->limit(5)
            ->get();
        foreach ($tasks as $task) {
            $results[] = [
                'name' => $task->task_name,
                'module' => 'Task',
                'url' => route('tasks.show', $task->id)
            ];
        }

        // Search Sub Admins
        $subAdmins = \App\Models\Admin::where('role', 'sub_admin')
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get();
        foreach ($subAdmins as $admin) {
            $results[] = [
                'name' => $admin->name,
                'module' => 'Sub Admin',
                'url' => route('admin.sub-admins.show', $admin->id)
            ];
        }

        // Search Visitors
        $visitors = \App\Models\Visitor::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get();
        foreach ($visitors as $visitor) {
            $results[] = [
                'name' => $visitor->name,
                'module' => 'Visitor',
                'url' => route('visitors.show', $visitor->id)
            ];
        }

        // Search Invited Visitors
        $invitedVisitors = \App\Models\InvitedVisitor::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get();
        foreach ($invitedVisitors as $iv) {
            $results[] = [
                'name' => $iv->name,
                'module' => 'Invited Visitor',
                'url' => route('invited-visitors.show', $iv->id)
            ];
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }

    return response()->json($results);
}

}
