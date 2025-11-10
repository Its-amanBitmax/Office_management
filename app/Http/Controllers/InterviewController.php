<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class InterviewController extends Controller
{
    /**
     * Display a listing of the interviews.
     */
    public function index()
    {
        $interviews = Interview::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.interviews.index', compact('interviews'));
    }

    /**
     * Show the form for creating a new interview.
     */
    public function create()
    {
        return view('admin.interviews.create');
    }

    /**
     * Store a newly created interview in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'candidate_email' => 'required|email|max:255|unique:interviews,candidate_email',
            'candidate_phone' => 'nullable|string|max:15',
            'candidate_resume_path' => 'nullable|file|mimes:pdf,doc,docx',
            'candidate_profile' => 'nullable|string',
            'candidate_experience' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'status' => ['required', Rule::in(['scheduled', 'completed', 'cancelled', 'rescheduled'])],
            'interview_code' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'results' => ['nullable', Rule::in(['pending', 'selected', 'rejected'])],
        ]);

        // Generate unique_id and unique_link
        $validated['unique_id'] = Str::uuid();
        $validated['unique_link'] = Str::uuid();

        // Handle empty results as null
        if (empty($validated['results'])) {
            $validated['results'] = null;
        }

        // Encrypt the password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Crypt::encryptString($validated['password']);
        }

        // Handle candidate resume upload
        if ($request->hasFile('candidate_resume_path')) {
            $validated['candidate_resume_path'] = $request->file('candidate_resume_path')->store('resumes', 'public');
        }

        Interview::create($validated);

        return redirect()->route('admin.interviews.index')->with('success', 'Interview created successfully.');
    }

    /**
     * Display the specified interview.
     */
    public function show(Interview $interview)
    {
        return view('admin.interviews.show', compact('interview'));
    }

    /**
     * Show the form for editing the specified interview.
     */
    public function edit(Interview $interview)
    {
        return view('admin.interviews.edit', compact('interview'));
    }

    /**
     * Update the specified interview in storage.
     */
    public function update(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'candidate_email' => ['required', 'email', 'max:255', Rule::unique('interviews')->ignore($interview->id)],
            'candidate_phone' => 'nullable|string|max:15',
            'candidate_resume_path' => 'nullable|file|mimes:pdf,doc,docx',
            'candidate_profile' => 'nullable|string',
            'candidate_experience' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'status' => ['required', Rule::in(['scheduled', 'completed', 'cancelled', 'rescheduled'])],
            'interview_code' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'results' => ['nullable', Rule::in(['pending', 'selected', 'rejected'])],
        ]);

        // Handle empty results as null
        if (empty($validated['results'])) {
            $validated['results'] = null;
        }

        // Encrypt the password if provided and different from current
        if (!empty($validated['password'])) {
            $currentPassword = $interview->decrypted_password;
            if ($validated['password'] !== $currentPassword) {
                $validated['password'] = Crypt::encryptString($validated['password']);
            } else {
                // Password is the same, keep current encrypted password
                unset($validated['password']);
            }
        } elseif (empty($validated['password'])) {
            // If password is empty, keep the current encrypted password
            unset($validated['password']);
        }

        // Handle candidate resume upload
        if ($request->hasFile('candidate_resume_path')) {
            if ($interview->candidate_resume_path) {
                Storage::disk('public')->delete($interview->candidate_resume_path);
            }
            $validated['candidate_resume_path'] = $request->file('candidate_resume_path')->store('resumes', 'public');
        }

        $interview->update($validated);

        return redirect()->route('admin.interviews.index')->with('success', 'Interview updated successfully.');
    }

    /**
     * Remove the specified interview from storage.
     */
    public function destroy(Interview $interview)
    {
        // Delete associated files
        if ($interview->candidate_resume_path) {
            Storage::disk('public')->delete($interview->candidate_resume_path);
        }

        $interview->delete();

        return redirect()->route('admin.interviews.index')->with('success', 'Interview deleted successfully.');
    }

    /**
     * Show the interview link page for candidates.
     */
    public function showInterviewLink($unique_link)
    {
        $interview = Interview::where('unique_link', $unique_link)->first();

        if (!$interview) {
            abort(404, 'Interview link not found.');
        }

        return view('interview.link', compact('interview'));
    }

    /**
     * Verify interview credentials.
     */
    public function verifyCredentials(Request $request, $unique_link)
    {
        $interview = Interview::where('unique_link', $unique_link)->first();

        if (!$interview) {
            return response()->json(['success' => false, 'message' => 'Interview not found.'], 404);
        }

        $request->validate([
            'interview_code' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if credentials match
        $decryptedPassword = $interview->decrypted_password;
        if ($request->interview_code === $interview->interview_code && $request->password === $decryptedPassword) {
            return response()->json([
                'success' => true,
                'message' => 'Credentials verified successfully! Interview access granted.',
                'is_started' => $interview->is_started
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid interview code or password.'
        ], 401);
    }

    /**
     * Start the interview.
     */
    public function startInterview($unique_link)
    {
        $interview = Interview::where('unique_link', $unique_link)->first();

        if (!$interview) {
            return response()->json(['success' => false, 'message' => 'Interview not found.'], 404);
        }

        $interview->update(['is_started' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Interview started successfully.'
        ]);
    }
}
