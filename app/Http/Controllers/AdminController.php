<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Admin;
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'salary-slips' => 'Salary Slips',
            'visitors' => 'Visitors',
            'invited-visitors' => 'Invited Visitors',
            'stock' => 'Stock Management',
            'performance' => 'Performance',
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
            'salary-slips' => 'Salary Slips',
            'visitors' => 'Visitors',
            'invited-visitors' => 'Invited Visitors',
            'stock' => 'Stock Management',
            'performance' => 'Performance',
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
            'salary-slips' => 'Salary Slips',
            'visitors' => 'Visitors',
            'invited-visitors' => 'Invited Visitors',
            'stock' => 'Stock Management',
            'performance' => 'Performance',
            'settings' => 'Settings',
            'logs' => 'Logs',
        ];

        return view('admin.sub-admins.show', compact('subAdmin', 'modules'));
    }

public function performance(Request $request)
    {
        $period = $request->get('period', 'all');
        $employeeId = $request->get('employee_id'); 

        // Get date range based on period
        $now = now();
        if ($period === 'all') {
            $startDate = now()->startOfYear(); // dummy for view
            $endDate = now()->endOfYear();
            $ratingsQuery = \App\Models\Rating::with('employee');
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
            $ratingsQuery = \App\Models\Rating::whereBetween('rating_date', [$startDate->toDateString(), $endDate->toDateString()])
                ->with('employee');
        }

        // Get all employees for dropdown
        $employees = \App\Models\Employee::select('id', 'name', 'employee_code')->orderBy('name')->get();

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
            'employees'
        ));
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

public function logs()
{
    $admin = Auth::guard('admin')->user();

    // Check if admin has permission to view logs
    if (!$admin->hasPermission('logs')) {
        return redirect()->route('admin.dashboard')
            ->with('error', 'You do not have permission to view logs');
    }

    $logs = \App\Models\ActivityLog::with('user')
        ->whereHas('user', function ($query) {
            $query->where('role', 'sub_admin');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('admin.logs', compact('admin', 'logs'));
}

}
