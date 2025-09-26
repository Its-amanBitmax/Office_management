<?php

namespace App\Exports;

use App\Models\Expense;
use App\Models\BudgetHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class MonthlyExpenseExport implements WithMultipleSheets
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function sheets(): array
    {
        return [
            new ExpensesSheet($this->month, $this->year),
            new BudgetHistorySheet($this->month, $this->year),
        ];
    }
}

class ExpensesSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return Expense::with('admin')
            ->whereYear('expense_date', $this->year)
            ->whereMonth('expense_date', $this->month)
            ->get()
            ->map(function ($expense) {
                return [
                    'Title' => $expense->title,
                    'Amount' => $expense->amount,
                    'Category' => $expense->category,
                    'Date' => $expense->expense_date->format('Y-m-d'),
                    'Created By' => $expense->admin->name ?? 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Title',
            'Amount',
            'Category',
            'Date',
            'Created By',
        ];
    }

    public function title(): string
    {
        return 'Expenses';
    }
}

class BudgetHistorySheet implements FromCollection, WithHeadings, WithTitle
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return BudgetHistory::with('admin')
            ->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->get()
            ->map(function ($history) {
                return [
                    'Action' => $history->action,
                    'Amount' => $history->amount,
                    'Old Budget' => $history->old_budget,
                    'New Budget' => $history->new_budget,
                    'Remaining' => $history->remaining,
                    'Created By' => $history->admin->name ?? 'N/A',
                    'Date' => $history->created_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Action',
            'Amount',
            'Old Budget',
            'New Budget',
            'Remaining',
            'Created By',
            'Date',
        ];
    }

    public function title(): string
    {
        return 'Budget History';
    }
}
