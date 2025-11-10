# Interview Room UI Differentiation Tasks

- [x] Wrap Interviewer Panel in @auth directive
- [x] Modify Questions & Answers panel for conditional display
  - [x] For interviewers (@auth): Show questions with answers
  - [x] For candidates (@guest): Show questions with answer input fields
- [x] Update JavaScript to add sendAnswer() function
- [x] Ensure Q&A list is dynamic for both questions and answers
- [x] Test UI for both interviewer and candidate roles

# Interview Start Functionality Tasks

- [x] Update status badge to show "Live" or "Waiting" based on $interview->is_started
- [x] Add startInterview() JavaScript function to handle interview start via AJAX
- [x] Implement modal for interviewers to start interview before candidate enters
- [x] Update UI dynamically after interview starts (hide modal, change status badge)

# Media Permissions and Controls Tasks

- [x] Add media permission modal with camera, microphone, and speaker status
- [x] Implement requestMediaPermissions() function to access camera and microphone
- [x] Add displayLocalVideo() function to show local video stream
- [x] Implement toggleMicrophone() and toggleCamera() functions
- [x] Add testSpeaker() function for speaker testing
- [x] Update control buttons to use actual media functions instead of placeholders
- [x] Add media cleanup on interview end (stop tracks)
- [x] Update permission status UI dynamically during permission requests
- [x] Handle permission errors (NotAllowedError, NotFoundError, etc.)
- [x] Add skipMediaSetup() function for users who want to skip media setup
