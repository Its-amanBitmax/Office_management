# TODO: Add Leave Request Sidebar to Attendance Page

## Tasks
- [x] Add sidebar to attendance page with "Request Leave" and "View My Requests" buttons
- [x] Create leave request index view with table showing Subject, Description, File, Status, Remarks
- [x] Create leave request create form with all required fields (leave_type, start_date, end_date, days, subject, description, file)
- [x] Implement modal for viewing leave request details
- [x] Add JavaScript for date calculation and form validation

## Admin Leave Requests Management
- [x] Update leave request create form to match database schema (subject, description fields)
- [x] Add leave-requests permission to sub-admin creation modules
- [x] Create admin leave requests views (index, show, create, edit)
- [x] Update LeaveRequestController for admin CRUD operations
- [x] Update routes for admin leave requests
- [x] Add "Manage Leave Requests" button to admin attendance page
- [x] Update employee leave request routes to use renamed methods
