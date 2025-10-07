# Fix Undefined $employee in task-assigned.blade.php

## Tasks
- [x] Modify TaskAssigned Mailable to accept Employee parameter
- [x] Update TaskController getAssigneeEmails to getAssignees returning Employee models
- [x] Update TaskController store method to send individual emails
- [x] Update TaskController update method to send individual emails
- [x] Verify the email view uses $employee correctly (already does)
