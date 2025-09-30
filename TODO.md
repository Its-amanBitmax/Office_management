# Task: Fix Expenses Module Visibility for Sub-Admin Users

## Completed Steps
- [x] Analyzed the issue: Expenses link is in HRM dropdown, but dropdown condition didn't include 'expenses' permission.
- [x] Updated `resources/views/layouts/admin.blade.php` to include 'expenses' in the HRM dropdown visibility check.

## Pending Steps
- [ ] Clear Laravel view cache: Run `php artisan view:clear` to ensure changes take effect.
- [ ] Test the fix: Log in as the affected sub-admin user and verify:
  - HRM dropdown appears in the sidebar.
  - Expenses link is visible and clickable under HRM.
  - If 'settings' permission was also assigned, confirm Settings menu is visible.
- [ ] If issues persist (e.g., route 404), check `routes/web.php` for `admin.expenses.index` route definition.
