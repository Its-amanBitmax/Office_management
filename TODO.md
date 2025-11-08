# TODO: Add Holiday Days Editing to Salary Slip Edit Form

## Tasks
- [ ] Add holiday days input field to the attendance summary section in `resources/views/admin/salary-slips/edit.blade.php`
- [ ] Update the controller's update method in `app/Http/Controllers/SalarySlipController.php` to validate and update holiday_days
- [ ] Ensure salary recalculation includes the updated holiday days in the controller
- [ ] Test the edit functionality to ensure holiday days can be updated and salary recalculated correctly
