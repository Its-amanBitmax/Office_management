<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();

        // Fetch dynamic stats
        $totalUsers = \App\Models\Employee::count();
        $activeTasks = \App\Models\Task::where('status', 'active')->count();
        $incompleteTasks = \App\Models\Task::where('status', '!=', 'completed')->count();
        $pendingReviews = \App\Models\Report::where('admin_status', 'pending')->count();
        $totalSalaryExpenses = \App\Models\Employee::sum(DB::raw('COALESCE(basic_salary, 0) + COALESCE(hra, 0) + COALESCE(conveyance, 0) + COALESCE(medical, 0)'));
        $systemAlerts = 0; // Placeholder for system alerts, can be implemented later if needed

        $tasks = \App\Models\Task::with(['assignedEmployee', 'teamLead'])->paginate(10);

        $recentEmployees = \App\Models\Employee::orderBy('created_at', 'desc')->take(5)->get();

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
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }

    public function performance(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $employeeId = $request->get('employee_id'); 

        // Get date range based on period
        $now = now();
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

        // Get all employees for dropdown
        $employees = \App\Models\Employee::select('id', 'name', 'employee_code')->orderBy('name')->get();

        // Get ratings from the ratings table within the period
        $ratingsQuery = \App\Models\Rating::whereBetween('rating_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->with('employee');

        // Apply employee filter if specified
        if ($employeeId) {
            $ratingsQuery->where('employee_id', $employeeId);
        }

        $ratings = $ratingsQuery->get();

        // Group by employee and calculate metrics based on ratings table
        $employeePerformance = [];
        $ratingDistribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
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
                    'rating_counts' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                    'performance_score' => 0
                ];
            }

            $employeePerformance[$empId]['total_ratings']++;
            $employeePerformance[$empId]['rating_sum'] += $stars;
            $employeePerformance[$empId]['total_stars'] += $stars;
            $employeePerformance[$empId]['rating_counts'][$stars]++;
            $employeePerformance[$empId]['average_rating'] = round($employeePerformance[$empId]['rating_sum'] / $employeePerformance[$empId]['total_ratings'], 1);

            // Calculate performance score (weighted average)
            $employeePerformance[$empId]['performance_score'] = $this->calculatePerformanceScore($employeePerformance[$empId]);

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
        $highRatingBonus = ($employeeData['rating_counts'][5] / max($totalRatings, 1)) * 0.5;

        return round($baseScore + $consistencyBonus + $highRatingBonus, 1);
    }
}
