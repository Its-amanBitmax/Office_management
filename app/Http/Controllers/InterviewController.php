<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\SignalingMessage;
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
        try {
            $interview = Interview::where('unique_link', $unique_link)->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found.'], 404, [], JSON_UNESCAPED_SLASHES);
            }

            $request->validate([
                'interview_code' => 'required|string',
                'password' => 'required|string',
            ]);

            $decryptedPassword = $interview->decrypted_password;
            if ($request->interview_code === $interview->interview_code && $request->password === $decryptedPassword) {
                // Set session flag for this interview link
                session(['interview_verified_' . $unique_link => true]);
                return response()->json([
                    'success' => true,
                    'message' => 'Credentials verified successfully! Interview access granted.',
                    'is_started' => $interview->is_started
                ], 200, [], JSON_UNESCAPED_SLASHES);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid interview code or password.'
            ], 401, [], JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['error' => true], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * Start the interview.
     */
    public function startInterview($unique_link)
    {
        try {
            $interview = Interview::where('unique_link', $unique_link)->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found.'], 404, [], JSON_UNESCAPED_SLASHES);
            }

            $interview->update(['is_started' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Interview started successfully.'
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['error' => true], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * Show the interview room for candidates.
     */
    public function showInterviewRoom($unique_link)
    {
        \Log::info('Session flag:', ['key' => 'interview_verified_' . $unique_link, 'value' => session('interview_verified_' . $unique_link, false)]);
        $interview = Interview::where('unique_link', $unique_link)->first();
        \Log::info('Interview status:', [
            'is_started' => $interview ? $interview->is_started : null,
            'link_status' => $interview ? $interview->link_status : null,
        ]);

        if (!$interview) {
            abort(404, 'Interview not found.');
        }

        // Bypass for debugging or admin (optional)
        if (
            request()->query('bypass') == '1'
            // || auth()->check() && auth()->user()->isAdmin() // Uncomment if you have admin logic
        ) {
            session(['interview_verified_' . $unique_link => true]);
        }

        // Fallback: Allow access if credentials are passed in GET (not secure, only for debugging)
        if (
            request()->has('interview_code') &&
            request()->has('password') &&
            request()->input('interview_code') === $interview->interview_code &&
            request()->input('password') === $interview->decrypted_password
        ) {
            session(['interview_verified_' . $unique_link => true]);
        }

        // Allow access if interview is started, even if session flag is missing
        if (!$interview->is_started) {
            return redirect()->route('interview.link', $unique_link)->with('error', 'Interview has not started yet.');
        }

        // Only check session flag if interview is not started
        if (!$interview->is_started && !session('interview_verified_' . $unique_link, false)) {
            return redirect()->route('interview.link', $unique_link)->with('error', 'Please verify your credentials to enter the interview room.');
        }

        \Log::info('Loading interview room for candidate: Interview ID ' . $interview->id . ', Unique Link: ' . $interview->unique_link);

        return view('interview.room', compact('interview') + ['is_interviewer' => false, 'is_candidate' => true]);
    }

    /**
     * Show the interview room for admins/interviewers.
     */
    public function showInterviewRoomAdmin(Interview $interview)
    {
        \Log::info('Loading interview room for interviewer: Interview ID ' . $interview->id);

        return view('interview.room', compact('interview') + ['is_interviewer' => true, 'is_candidate' => false]);
    }

    /**
     * Log JavaScript errors from the frontend.
     */
    public function logError(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string', // Remove "in:" for flexibility
                'filename' => 'nullable|string',
                'lineno' => 'nullable|integer',
                'colno' => 'nullable|integer',
                'error' => 'nullable|string',
            ]);

            \Log::error('JavaScript Error: ' . $request->message, [
                'filename' => $request->filename,
                'lineno' => $request->lineno,
                'colno' => $request->colno,
                'error' => $request->error,
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
            ]);

            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['error' => true], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * Send WebRTC signaling message (including questions).
     */
    public function sendSignalingMessage(Request $request, $unique_link)
    {
        try {
            $interview = Interview::where('unique_link', $unique_link)->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found.'], 404, [], JSON_UNESCAPED_SLASHES);
            }

            $type = $request->query('type', $request->input('type'));
            $sender = $request->query('sender_type', $request->input('sender_type'));

            // Very important: raw body for SDP
            $contentType = $request->header('Content-Type');
            $sdp = null;

            if (str_contains($contentType, 'text/plain') || str_contains($contentType, 'application/sdp')) {
                $sdp = $request->getContent(); // RAW SDP!
            } else {
                $sdp = $request->input('sdp');
            }

            $msg = SignalingMessage::create([
                'interview_id' => $interview->id,
                'sender_type'  => $sender,
                'type'         => $type,
                'sdp'          => $sdp,
                'ice_candidate'=> $request->input('ice_candidate'),
                'text'         => $request->input('text'),
                'question_id'  => $request->input('question_id'),
            ]);

            return response()->json([
                'success' => true,
                'message_id' => $msg->id
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * Get pending WebRTC signaling messages.
     */
    public function getSignalingMessages(Request $request, $unique_link)
    {
        try {
            $interview = Interview::where('unique_link', $unique_link)->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found.'], 404, [], JSON_UNESCAPED_SLASHES);
            }

            $request->validate([
                'receiver_type' => 'required|string', // Remove "in:" for flexibility
                'last_message_id' => 'nullable|integer',
                'check_online' => 'nullable|boolean',
            ]);

            $receiverType = $request->receiver_type;

            // Check if peer is online (has sent messages recently)
            $peerOnline = false;
            if ($request->check_online) {
                $oppositeType = $receiverType === 'interviewer' ? 'candidate' : 'interviewer';
                $recentMessages = SignalingMessage::where('interview_id', $interview->id)
                    ->where('sender_type', $oppositeType)
                    ->where('created_at', '>=', now()->subSeconds(30)) // Active in last 30 seconds
                    ->exists();
                $peerOnline = $recentMessages;
            }

            $query = SignalingMessage::where('interview_id', $interview->id)
                ->where('delivered', false)
                ->where(function ($q) use ($receiverType) {
                    // Target must match receiver, or null (broadcast)
                    $q->where('target_type', $receiverType)
                      ->orWhereNull('target_type');
                });

            if ($request->last_message_id) {
                $query->where('id', '>', $request->last_message_id);
            }

            $messages = $query->orderBy('created_at', 'asc')->get();

            // Mark messages as delivered
            foreach ($messages as $message) {
                $message->markAsDelivered();
            }

            return response()->json([
                'success' => true,
                'peer_online' => $peerOnline,
                'messages' => $messages->map(function ($message) {
                    $response = [
                        'id' => $message->id,
                        'type' => $message->type,
                        'sender_type' => $message->sender_type,
                        'created_at' => $message->created_at->toISOString(),
                    ];

                    if ($message->type === 'offer' || $message->type === 'answer') {
                        \Log::info('Sending SDP length=' . strlen($message->sdp));
                        $response['sdp'] = $message->sdp;
                    } elseif ($message->type === 'ice-candidate') {
                        $response['ice_candidate'] = $message->ice_candidate;
                    } elseif ($message->type === 'question') {
                        $response['text'] = $message->text;
                        $response['question_id'] = $message->question_id;
                    }

                    return $response;
                }),
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['error' => true], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }

        /**
     * Clear old signaling messages for an interview.
     */
    public function clearSignalingMessages($unique_link)
    {
        try {
            $interview = Interview::where('unique_link', $unique_link)->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found.'], 404, [], JSON_UNESCAPED_SLASHES);
            }

            // Delete messages older than 1 hour
            SignalingMessage::where('interview_id', $interview->id)
                ->where('created_at', '<', now()->subHour())
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Signaling messages cleared successfully.'
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['error' => true], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }
     public function toggleLinkStatus($id)
    {
        $interview = Interview::findOrFail($id);

        // Toggle logic (0 <-> 1)
        $interview->link_status = $interview->link_status == '1' ? '0' : '1';
        $interview->save();

        return redirect()->back()->with('success', 'Link status updated successfully');
    }

    /**
     * End the interview and deactivate the link (for both sides).
     */
    public function endInterview($unique_link)
    {
        try {
            $interview = Interview::where('unique_link', $unique_link)->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found.'], 404, [], JSON_UNESCAPED_SLASHES);
            }

            // Set link_status and is_started to 0 (inactive)
            $interview->update([
                'link_status' => '0',
                'is_started' => 0
            ]);

            // Broadcast a socket.io message to force end for the other side
            try {
                $http = new \GuzzleHttp\Client(['timeout' => 2]);
                $socketServer = 'https://socket.bitmaxgroup.com/interview-force-end';
                $http->post($socketServer, [
                    'json' => [
                        'room' => 'interview.' . $unique_link,
                        'action' => 'force-end'
                    ]
                ]);
            } catch (\Throwable $e) {
                \Log::warning('Could not notify socket server for force end: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Interview ended and link deactivated.'
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['error' => true], 500, [], JSON_UNESCAPED_SLASHES);
        }
    }
}

