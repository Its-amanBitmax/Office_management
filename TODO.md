# TODO: Add 'terminated' and 'resigned' to Employee Status

## Steps to Complete:
- [x] Update validation rules in `app/Http/Controllers/EmployeeController.php` to include 'terminated' and 'resigned'
- [x] Update `resources/views/employee/create.blade.php` to add new status options in dropdown
- [x] Update `resources/views/employee/edit.blade.php` to add new status options in dropdown
- [x] Update `resources/views/employee/index.blade.php` to handle display of new statuses
- [x] Update `resources/views/employee/show.blade.php` to handle display of new statuses
- [x] Update `resources/views/employee/profile.blade.php` to handle display of new statuses
- [ ] Optionally add status constants in `app/Models/Employee.php`
- [ ] Test the application to ensure new statuses work correctly
