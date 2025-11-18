# Evaluation Scoring Changes TODO

## Overview
Modify evaluation system to change scoring and add department-based logic.

## Changes Required
1. **Scoring Adjustments:**
   - Manager evaluation: 60 → 30 points (change multiplier from 12/5 to 6/5)
   - HR evaluation: 30 → 20 points (change multiplier from 6/5 to 4/5)
   - Overall evaluation: 100 → 50 points (adjust slider max values proportionally)

2. **Department Logic:**
   - Skip manager evaluation if employee has no department
   - Show manager section conditionally based on employee's department field

## Files to Modify
- [ ] `app/Http/Controllers/AdminController.php` - Update calculation logic
- [ ] `resources/views/admin/add-evaluation-report.blade.php` - Update display and conditional logic
- [ ] `resources/views/admin/evaluation-report.blade.php` - Update display for viewing reports

## Implementation Steps
1. Update AdminController calculation methods
2. Update add-evaluation-report view for conditional display and new totals
3. Update evaluation-report view for correct display
4. Test the changes

## Progress
- [x] Plan approved by user
- [x] Update AdminController.php scoring multipliers
- [x] Update AdminController.php overall slider max values
- [x] Update add-evaluation-report.blade.php conditional display
- [x] Update evaluation-report.blade.php display
- [ ] Test changes
