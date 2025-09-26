<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('admin')->orderBy('expense_date', 'desc')->paginate(10);
        $budget = ExpenseBudget::getCurrentBudget();
        return view('expenses.index', compact('expenses', 'budget'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:100',
            'expense_date' => 'required|date',
        ]);

        $budget = ExpenseBudget::getCurrentBudget();

        // Check if there's enough budget
        if ($budget->remaining_amount < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient budget. Remaining budget: $' . number_format($budget->remaining_amount, 2)])->withInput();
        }

        Expense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date,
            'created_by' => Auth::guard('admin')->id(),
        ]);

        // Deduct from budget
        $budget->deductAmount($request->amount);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense added successfully!');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string|max:100',
            'expense_date' => 'required|date',
        ]);

        $budget = ExpenseBudget::getCurrentBudget();
        $oldAmount = $expense->amount;
        $newAmount = $request->amount;

        // Check if there's enough budget for the difference
        if ($newAmount > $oldAmount) {
            $difference = $newAmount - $oldAmount;
            if ($budget->remaining_amount < $difference) {
                return back()->withErrors(['amount' => 'Insufficient budget. Remaining budget: $' . number_format($budget->remaining_amount, 2)])->withInput();
            }
        }

        $expense->update($request->all());

        // Adjust budget
        $budget->adjustAmount($oldAmount, $newAmount);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        $budget = ExpenseBudget::getCurrentBudget();
        $amount = $expense->amount;

        $expense->delete();

        // Add back to budget
        $budget->addBackAmount($amount);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted successfully!');
    }

    public function updateBudget(Request $request)
    {
        // Only super admin can update budget
        if (!auth('admin')->user()->is_super_admin ?? false) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'budget_amount' => 'required|numeric|min:0',
        ]);

        $budget = ExpenseBudget::getCurrentBudget();
        $newBudgetAmount = $request->budget_amount;

        // Calculate new remaining amount
        $spentAmount = $budget->budget_amount - $budget->remaining_amount;
        $newRemainingAmount = max(0, $newBudgetAmount - $spentAmount);

        $budget->update([
            'budget_amount' => $newBudgetAmount,
            'remaining_amount' => $newRemainingAmount,
        ]);

        return redirect()->route('admin.expenses.index')->with('success', 'Budget updated successfully!');
    }

    public function addBudget(Request $request)
    {
        // Only super admin can add budget
        if (!auth('admin')->user()->is_super_admin ?? false) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'add_amount' => 'required|numeric|min:0',
        ]);

        $budget = ExpenseBudget::getCurrentBudget();
        $addAmount = $request->add_amount;

        $budget->budget_amount += $addAmount;
        $budget->remaining_amount += $addAmount;
        $budget->save();

        return redirect()->route('admin.expenses.index')->with('success', 'Budget added successfully! Added ₹' . number_format($addAmount, 2));
    }
}
