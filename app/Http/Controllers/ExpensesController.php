<?php

namespace App\Http\Controllers;

use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function create()
    {
        $sales = Sale::where('year', Carbon::now()->year)->get();
        if(count($sales) === 0) {
            return redirect()->route('sales.create')->with(['success' => 'please create sales first ']);
        }
        return view('pages.expenses.create')->with([
            'page_title' => 'Record Sales Expenses',
            'page_description' => 'The expenses of the sales',
            'sales' => $sales
        ]);
    }

    public function store(Request $request)
    {
        $profits = $request->profit;
        foreach($profits as $saleId => $profitValue) {
            Sale::where('id', $saleId)->update(['expenses' => $profitValue]);
        }
        return back()->with([
            'success' => 'Sales expenses has been recorded successfully!'
        ]);
    }
}
