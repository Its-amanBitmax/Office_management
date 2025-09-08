<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index()
    {
        $tasks = Task::with(['assignedEmployee', 'teamLead'])->paginate(10);
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $employees = Employee::select('id', 'name', 'employee_code')->where('status', 'active')->get();
        return view('task.create', compact('employees'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'nullable|exists:employees,id',
            'assigned_team' => ['required', Rule::in(['Individual', 'Team'])],
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:employees,id',
            'team_lead_id' => 'nullable|required_if:assigned_team,Team|exists:employees,id',
            'team_created_by' => ['nullable', Rule::in(['admin', 'team_lead'])],
            'selected_team' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => ['required', Rule::in(['Not Started', 'In Progress', 'Completed', 'On Hold'])],
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'progress' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validated['assigned_team'] === 'Individual') {
            $validated['team_members'] = null;
            $validated['team_lead_id'] = null;
        } elseif ($validated['assigned_team'] === 'Team') {
            $validated['assigned_to'] = null;
        }

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $task->load(['assignedEmployee', 'teamLead']);
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $employees = Employee::select('id', 'name', 'employee_code')->where('status', 'active')->get();
        $tasks = Task::select('id', 'task_name')->get();
        return view('task.edit', compact('task', 'employees', 'tasks'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'nullable|exists:employees,id',
            'assigned_team' => ['required', Rule::in(['Individual', 'Team'])],
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:employees,id',
            'team_lead_id' => 'nullable|required_if:assigned_team,Team|exists:employees,id',
            'team_created_by' => ['nullable', Rule::in(['admin', 'team_lead'])],
            'selected_team' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => ['required', Rule::in(['Not Started', 'In Progress', 'Completed', 'On Hold'])],
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'progress' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validated['assigned_team'] === 'Individual') {
            $validated['team_members'] = null;
            $validated['team_lead_id'] = null;
        } elseif ($validated['assigned_team'] === 'Team') {
            $validated['assigned_to'] = null;
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
