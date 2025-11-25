# Fixing 419 CSRF Error on /interview/{uuid}/start

## Steps:

- [x] Edit `resources/views/interview/room.blade.php`:
  - Update `startInterview()` JS function to include `X-CSRF-TOKEN` header from meta tag.
  - Add `credentials: 'same-origin'` and `Content-Type: 'application/json'` for consistency.
  - Include empty JSON body.

- [x] Test the changes:
  - Create/load an interview not started.
  - As interviewer, visit `/admin/interviews/{id}/room`.
  - Click "Start Interview" modal button → should succeed without 419, hide modal, init WebRTC.

- [x] Verify no regressions:
  - Candidate flow in `link.blade.php` (already has CSRF).
  - Signaling routes (already excluded).

- [x] Update TODO.md upon completion of each step.

Current status: Task completed. The 419 CSRF error on POST /interview/{uuid}/start is fixed by adding the missing X-CSRF-TOKEN header to the interviewer's startInterview() fetch in room.blade.php.
