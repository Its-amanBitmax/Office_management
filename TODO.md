# Task: Filter Inactive Employees in Monthly Attendance View

## Description
Modify the monthly attendance view to show inactive employees only for past months. For the current month and future months, only show active employees.

## Steps
- [x] Modify AttendanceController showMonthly method to filter employees based on inactive date
- [x] Test the changes by viewing past and current months

# Task: Add Interviews Permission to Sub-Admin Management

## Description
Add 'interviews' permission to the modules array in AdminController for sub-admin creation, editing, and viewing.

## Steps
- [x] Add 'interviews' => 'Interviews' to the modules array in createSubAdmin method
- [x] Add 'interviews' => 'Interviews' to the modules array in editSubAdmin method
- [x] Add 'interviews' => 'Interviews' to the modules array in show method

# Task: Add NCNS and LWP Status Options to Attendance Forms

## Description
Add NCNS (No Call No Show) and LWP (Leave Without Pay) status options to attendance creation and editing forms.

## Steps
- [x] Add NCNS and LWP options to create.blade.php status dropdown
- [x] Add NCNS and LWP options to edit.blade.php status dropdown
- [x] Verify NCNS and LWP are already supported in AttendanceController validation
