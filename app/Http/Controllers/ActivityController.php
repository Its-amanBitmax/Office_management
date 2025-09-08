<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Employee;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('employees')->get();
        return view('activities.index', compact('activities'));
    }

    public function create(Request $request)
    {
        $title = $request->input('title', '');
        $employees = Employee::all();
        return view('activities.create', compact('title', 'employees'));
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,active,completed',
        'schedule_at' => 'nullable|date',
        'employees' => 'nullable|array',
        'employees.*' => 'exists:employees,id',
        'criteria' => 'nullable|array',
        'scoring_scope' => 'required|in:selected,all',
        'best_employee_id' => 'nullable|exists:employees,id',
        'best_employee_description' => 'nullable|string',
        'keep_best_employee' => 'boolean',
        'enable_best_employee' => 'boolean',
        'criteria.*.name' => 'required_with:criteria|string|max:255',
        'criteria.*.description' => 'nullable|string',
        'criteria.*.max_points' => 'required_with:criteria|integer|min:1',
    ]);


   $activity = Activity::create($request->only(['title', 'description', 'status', 'schedule_at', 'scoring_scope', 'best_employee_id', 'best_employee_description', 'keep_best_employee', 'enable_best_employee']));


    if ($request->has('employees')) {
        $activity->employees()->sync($request->input('employees'));
    }

    // ✅ Criteria save
    if ($request->has('criteria')) {
        foreach ($request->input('criteria') as $criterion) {
            $activity->criteria()->create($criterion);
        }
    }

    return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
}



    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $employees = \App\Models\Employee::all();
        return view('activities.edit', compact('activity', 'employees'));
    }

public function update(Request $request, Activity $activity)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,active,completed',
        'schedule_at' => 'nullable|date',
        'employees' => 'nullable|array',
        'employees.*' => 'exists:employees,id',
        'scoring_scope' => 'required|in:selected,all',
        'best_employee_id' => 'nullable|exists:employees,id',
        'best_employee_description' => 'nullable|string',
        'keep_best_employee' => 'boolean',
        'criteria' => 'nullable|array',
        'criteria.*.name' => 'required_with:criteria|string|max:255',
        'criteria.*.description' => 'nullable|string',
        'criteria.*.max_points' => 'required_with:criteria|integer|min:1',
    ]);

    
    $activity->update($request->only(['title', 'description', 'status', 'schedule_at', 'scoring_scope', 'best_employee_id', 'best_employee_description', 'keep_best_employee', 'enable_best_employee']));


    if ($request->has('employees')) {
        $activity->employees()->sync($request->input('employees'));
    }

    // ✅ Purane criteria delete karke naya save
    $activity->criteria()->delete();

    if ($request->has('criteria')) {
        foreach ($request->input('criteria') as $criterion) {
            $activity->criteria()->create($criterion);
        }
    }

    return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
}


    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
