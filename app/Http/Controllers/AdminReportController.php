<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('sent_to_admin', true)
            ->with('employee', 'task')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::where('sent_to_admin', true)
            ->with('employee', 'task')
            ->findOrFail($id);

        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sent,read,responded',
            'review' => 'nullable|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $report = Report::where('sent_to_admin', true)->findOrFail($id);

        $updateData = [
            'admin_status' => $request->status,
            'admin_review' => $request->review,
        ];

        // Only save rating when task is completed
        if ($report->task && $report->task->status === 'Completed' && $request->rating) {
            $updateData['admin_rating'] = $request->rating;
        }

        $report->update($updateData);

        return redirect()->route('admin.reports.show', $report->id)->with('success', 'Report updated successfully!');
    }
}
