# TODO: Fix Net Salary Calculation for NCNS and LWP Attendance Statuses

## Completed Tasks
- [x] Update SalarySlip model to include ncns_days and lwp_days fields
- [x] Update SalarySlipController calculateAttendanceData() to include ncns and lwp counts
- [x] Update SalarySlipController calculateSalary() to subtract ncns and lwp from effective days
- [x] Update SalarySlipController store() to save ncns_days and lwp_days
- [x] Update SalarySlipController update() to include ncns and lwp in attendanceData array
- [x] Update show.blade.php to display ncns and lwp in attendance summary table
- [ ] Test the changes by regenerating a salary slip
