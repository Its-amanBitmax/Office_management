# Monthly Expense Excel Report Implementation

## Steps to Complete
- [x] Install maatwebsite/excel package
- [x] Create migration for expense_budget_history table
- [x] Create BudgetHistory model
- [x] Update ExpenseController to log budget history in updateBudget and addBudget methods
- [x] Create app/Exports/MonthlyExpenseExport.php class
- [x] Add export route in routes/web.php
- [x] Update resources/views/expenses/index.blade.php to add month/year selection form and download button
- [x] Add export method in ExpenseController
- [x] Run the new migration
- [x] Add remaining column to budget history table and export
- [ ] Test the Excel export functionality

# Logs Module Implementation

## Steps to Complete
- [x] Create migration for activity_logs table
- [x] Create ActivityLog model
- [x] Create Loggable trait for logging activities
- [x] Update AdminController logs method to fetch and display logs
- [x] Update logs.blade.php to display logs in a table
- [x] Add logging to ExpenseController for create/update/delete actions
- [x] Add logging to AdminController for login/logout actions
- [x] Run the migration
- [ ] Test the logs functionality
