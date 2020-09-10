<?php

namespace App\Http\Controllers\Financer;

use App\Budget;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware([ 'auth', 'can:financer']);
    }

    public function index()
    {
        $budgets = Budget::orderBy('title')->paginate(8);

        return view('financer.budgets.list', [
            'budgets' => $budgets,
        ]);
    }

    public function create()
    {
        return view('financer.budgets.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:budgets'
        ]);
        $title = $request->input('title');

        $budget = new Budget();
        $budget->title = $title;
        $budget->save();
        return redirect()->route('budgets');
    }
}
