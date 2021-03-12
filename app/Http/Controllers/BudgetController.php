<?php

namespace App\Http\Controllers;

use App\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        return view('pages.budget.index')->with([
            'page_title' => 'budget',
            'page_description' => 'Show all budget',
            'budget' => Budget::orderBy('year', 'desc')->orderBy('month', 'desc')->get()
        ]);
    }

    public function edit($id)
    {
        $budget = Budget::where('id', $id)->firstOrFail();
        return view('pages.budget.edit')->with([
            'page_title' => 'Edit Budget',
            'page_description' => 'Edit a particular Budget',
            'budget' => $budget
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'month' => 'required' ,
            'cash' => 'required',
            'credit' => 'required',
            'total' => 'required',
            'net' => 'required',
        ]);

        [$month, $year] = explode('-',$request->month);
        $monthInsertedBefore = Budget::where('year', $year)->where('month', $month)->count();

        if($monthInsertedBefore > 1) {
            return back()->with(['error' => 'The budget for this month has been inserted before!, go to budget page if you want to edit']);
        }


        $data = [
            'year' => $year,
            'month' => $month,
            'cash' => $request->cash,
            'credit' => $request->credit,
            'total' => $request->total,
            'returns' => $request->returns,
            'net' => $request->net,
            'user_id' => 1
        ];

        $budget = Budget::where('id', $id)->firstOrFail();

        $budget->update($data);
        if(Budget::count() > 1) {
            $data = [];
            $budgets = Budget::orderBy('year', 'asc')->orderBy('month', 'asc')->where('year', $year)->get();

            foreach($budgets as $key => $budgetObject) {
                $grossProfit = $budgetObject->net - $budgetObject->cost_of_sales;
                $netProfit =  $grossProfit - $budgetObject->expenses;
                $netSalesCum =$key === 0 ? $budgetObject->net : $budgetObject->net + $budgets[$key-1]->net;
                $netProfitPercentage = $netProfit / $netSalesCum * 100;
                $grossProfitPercentage = $grossProfit / $budgetObject->net * 100;
                $grossProfitCum = $key === 0 ? $grossProfit: $budgetObject->g_profit_cum + $grossProfit;
                $grossProfitCumPercentage = $netProfit / $netSalesCum * 100;
                $data['g_profit'] = $grossProfit;
                $data['g_profit_percentage'] = $grossProfitPercentage;
                $data['net_profit'] = $netProfit;
                $data['net_sales_cum'] = $netSalesCum;
                $data['net_profit_percentage'] = $netProfitPercentage;
                $data['g_profit_cum_percentage'] = $grossProfitCumPercentage;
                $data['g_profit_cum'] = $grossProfitCum;
                $budgetObject->update($data);
            }
        }

        return back()->with(['success' => 'Budget has been updated successfully']);
    }

    public function create()
    {
        return view('pages.budget.create')->with([
            'page_title' => 'Create Monthly budget',
            'page_description' => 'Add new budget record for a particular month',
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'month' => 'required' ,
            'cash' => 'required',
            'credit' => 'required',
            'total' => 'required',
            'net' => 'required',
        ]);
        [$month, $year] = explode('-',$request->month);

        $monthInsertedBefore = Budget::where('year', $year)->where('month', $month)->count();
        if($monthInsertedBefore > 0) {
            return back()->with(['error' => 'The sales for this month has been inserted before!, go to sales page if you want to edit']);
        }

        $data = $request->except('_token');
        $grossProfit = $data['net'] - $data['cost_of_sales'];
        $lastInsertedMonth = Budget::latest()->first();
        $netSales = $data['net'];
        $netProfit =  $grossProfit - $data['expenses'];
        $netSalesCum = isset($lastInsertedMonth) ? $lastInsertedMonth->net +$netSales : $netSales;
        $netProfitPercentage = $netProfit / $netSalesCum * 100;
        $grossProfitPercentage = $grossProfit / $netSales * 100;
        $grossProfitCum = isset($lastInsertedMonth) ? $lastInsertedMonth->g_profit_cum + $grossProfit : $grossProfit;
        $grossProfitCumPercentage = $netProfit / $netSalesCum * 100;

        $data['year'] = $year;
        $data['month'] = $month;
        $data['user_id'] = auth()->id() ?? 1;
        $data['g_profit'] = $grossProfit;
        $data['g_profit_percentage'] = $grossProfitPercentage;
        $data['net_profit'] = $netProfit;
        $data['net_sales_cum'] = $netSalesCum;
        $data['net_profit_percentage'] = $netProfitPercentage;
        $data['g_profit_cum_percentage'] = $grossProfitCumPercentage;
        $data['g_profit_cum'] = $grossProfitCum;


        Budget::create($data);
        session()->flash('success', 'Monthly budget Report Has Been Created Successfully !');
        return redirect()->route('budget.index');
    }

    public function destroy($id)
    {
        $Budget = Budget::where('id', $id)->firstOrFail();
        $Budget->delete();
        return back()->with('success', 'Budget report has been delete successfully!');
    }
}
