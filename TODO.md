# Task: Fix Super Admin Log Activities Not Showing in Logs (Filter to Sub-Admins Only and Fix User Loading)

## Steps to Complete:

### 1. Update Loggable Trait for Proper Polymorphic Relations
- File: app/Traits/Loggable.php
- Change user_type to full class names ('App\\Models\\Admin' for admins, 'App\\Models\\Employee' for employees) to enable correct morphTo loading.
- Purpose: Ensures sub-admin names and types load properly in logs view (fixes "Unknown" display).

### 2. Filter Logs in AdminController to Exclude Super Admins
- File: app/Http/Controllers/AdminController.php
- Update logs() method query to use whereHas('user', function($q) { $q->where('role', 'sub_admin'); }) on ActivityLog.
- Purpose: Only fetch and display sub-admin activities, excluding super admin logs.

### 3. Clear Application Cache
- Run: `php artisan cache:clear && php artisan config:clear`
- Purpose: Refresh relations, models, and cached data to apply changes.

### 4. Test the Changes
- Log in as super admin, perform an action (e.g., update profile) – verify it does NOT appear in /admin/logs.
- Log in as sub-admin, perform an action – verify it appears with correct name and type (not "Unknown").
- Check database if needed: SELECT * FROM activity_logs WHERE user_type = 'App\\Models\\Admin' AND user_id IN (SELECT id FROM admins WHERE role = 'sub_admin');

## Progress:
- [ ] Step 1
- [x] Step 2
- [ ] Step 3
- [ ] Step 4
