# Step-by-Step Evaluation Submission Implementation

## Overview
Implement a multi-step evaluation form with progress tracking, draft saving, and step-by-step navigation.

## Steps to Complete

### 1. Update Controller Methods
- [ ] Add `saveEvaluationDraft` method to handle partial submissions
- [ ] Modify `storeEvaluationReport` to handle final submission
- [ ] Add validation for each step individually
- [ ] Update routes to include draft saving endpoint

### 2. Restructure Form View
- [ ] Convert single form into 4-step wizard (Employee Details, Manager Eval, HR Eval, Overall Eval)
- [ ] Add progress bar with step indicators
- [ ] Implement step navigation (Next/Previous buttons)
- [ ] Add step validation before proceeding
- [ ] Show only accessible steps based on permissions

### 3. Add JavaScript Functionality
- [ ] Step navigation logic with validation
- [ ] Progress bar updates
- [ ] Draft auto-save on step changes
- [ ] Form data persistence between steps
- [ ] Client-side validation per step

### 4. Update Database/Model Logic
- [ ] Add draft status tracking to EvaluationReport model
- [ ] Ensure partial data saving works correctly
- [ ] Handle step completion flags

### 5. Testing and Validation
- [ ] Test step navigation and validation
- [ ] Verify draft saving functionality
- [ ] Test permission-based step access
- [ ] Ensure final submission works correctly

## Files to Modify
- `app/Http/Controllers/AdminController.php`
- `resources/views/admin/add-evaluation-report.blade.php`
- `routes/web.php` (if needed)
- `app/Models/EvaluationReport.php` (if needed)

## Current Status
- Analysis complete
- Plan approved by user
- Ready to start implementation
