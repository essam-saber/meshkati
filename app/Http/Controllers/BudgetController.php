<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Http\Requests\StoreActualSalesRequest;
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

    public function update(StoreActualSalesRequest $request, $id)
    {
        [$month, $year] = explode('-',$request->month);
        $monthInsertedBefore = Budget::where('year', $year)->where('month', $month)->count();

        if($monthInsertedBefore > 1) {
            return back()->with(['error' => 'The budget for this month has been inserted before!, go to budget page if you want to edit']);
        }

        $data = $request->except('_token');


        $netSales = $data['net_sales'];
        $netSalesCum = isset($lastInsertedMonth) ? $netSales + $lastInsertedMonth->net_sales_cum : $netSales;
        $grossProfit = $netSales - $data['cost_of_sales'];
        $grossProfitCum = isset($lastInsertedMonth) ? $lastInsertedMonth->gross_profit_cum + $grossProfit : $grossProfit;
        $grossProfitPercentage = $grossProfit / $netSales * 100;
        $grossProfitCumPercentage = $grossProfitCum / $netSalesCum * 100;
        $netProfit =  $grossProfit - $data['expenses'];
        $netProfitPercentage = $netProfit / $netSales * 100;
        $netProfitCum =  isset($lastInsertedMonth) ? $lastInsertedMonth->net_profit_cum + $netProfit : $netProfit;
        $netProfitCumPercentage = $netProfitCum / $netSalesCum * 100;

        $sale = Budget::where('id', $id)->firstOrFail();
        $data['year'] = $year;
        $data['month'] = $month;
        $data['net_sales_cum'] = $netSalesCum;
        $data['gross_profit'] = $grossProfit;
        $data['gross_profit_cum'] = $grossProfitCum;
        $data['gross_profit_percentage'] = $grossProfitPercentage;
        $data['gross_profit_cum_percentage'] = $grossProfitCumPercentage;
        $data['net_profit'] = $netProfit;
        $data['net_profit_cum'] = $netProfitCum;
        $data['net_profit_percentage'] = $netProfitPercentage;
        $data['net_profit_cum_percentage'] = $netProfitCumPercentage;
        $sale->update($data);

        if(Budget::count() > 1) {
            $budgets = Budget::where('year', $year)->ascOrder()->get();
            foreach($budgets as $key => $sale) {
                $data = [];
                $netSalesCum = $key !== 0 ? $sale->net_sales + $budgets[$key-1]->net_sales_cum : $sale->net_sales;
                $grossProfit = $sale->net_sales - $sale->cost_of_sales;
                $grossProfitCum = $key !== 0 ? $budgets[$key-1]->gross_profit_cum + $grossProfit : $grossProfit;
                $grossProfitPercentage = $grossProfit / $sale->net_sales * 100;
                $grossProfitCumPercentage = $grossProfitCum / $netSalesCum * 100;
                $netProfit =  $grossProfit - $sale->expenses;
                $netProfitPercentage = $netProfit / $sale->net_sales * 100;
                $netProfitCum =  $key !== 0 ? $budgets[$key-1]->net_profit_cum + $netProfit : $netProfit;
                $netProfitCumPercentage = $netProfitCum / $netSalesCum * 100;

                $data['net_sales_cum'] = $netSalesCum;
                $data['gross_profit'] = $grossProfit;
                $data['gross_profit_cum'] = $grossProfitCum;
                $data['gross_profit_percentage'] = $grossProfitPercentage;
                $data['gross_profit_cum_percentage'] = $grossProfitCumPercentage;
                $data['net_profit'] = $netProfit;
                $data['net_profit_cum'] = $netProfitCum;
                $data['net_profit_percentage'] = $netProfitPercentage;
                $data['net_profit_cum_percentage'] = $netProfitCumPercentage;
                $sale->update($data);
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

    public function store(StoreActualSalesRequest $request)
    {
        [$month, $year] = explode('-',$request->month);

        $monthInsertedBefore = Budget::where('year', $year)->where('month', $month)->count();
        if($monthInsertedBefore > 0) {
            return back()->with(['error' => 'The sales for this month has been inserted before!, go to sales page if you want to edit']);
        }
        $lastInsertedMonth = Budget::latest()->first();
        $data = $request->except('_token');
        $netSales = $data['net_sales'];
        $netSalesCum = isset($lastInsertedMonth) ? $netSales + $lastInsertedMonth->net_sales_cum : $netSales;
        $grossProfit = $netSales - $data['cost_of_sales'];
        $grossProfitCum = isset($lastInsertedMonth) ? $lastInsertedMonth->gross_profit_cum + $grossProfit : $grossProfit;
        $grossProfitPercentage = $grossProfit / $netSales * 100;
        $grossProfitCumPercentage = $grossProfitCum / $netSalesCum * 100;
        $netProfit =  $grossProfit - $data['expenses'];
        $netProfitPercentage = $netProfit / $netSales * 100;
        $netProfitCum =  isset($lastInsertedMonth) ? $lastInsertedMonth->net_profit_cum + $netProfit : $netProfit;
        $netProfitCumPercentage = $netProfitCum / $netSalesCum * 100;

        $data['year'] = $year;
        $data['month'] = $month;
        $data['user_id'] = auth()->id() ?? 1;
        $data['net_sales_cum'] = $netSalesCum;
        $data['gross_profit'] = $grossProfit;
        $data['gross_profit_cum'] = $grossProfitCum;
        $data['gross_profit_percentage'] = $grossProfitPercentage;
        $data['gross_profit_cum_percentage'] = $grossProfitCumPercentage;
        $data['net_profit'] = $netProfit;
        $data['net_profit_cum'] = $netProfitCum;
        $data['net_profit_percentage'] = $netProfitPercentage;
        $data['net_profit_cum_percentage'] = $netProfitCumPercentage;

        Budget::create($data);
        session()->flash('success', 'Monthly budget Has Been Created Successfully !');
        return redirect()->route('budget.index');
    }

    public function destroy($id)
    {
        $Budget = Budget::where('id', $id)->firstOrFail();
        $Budget->delete();
        return back()->with('success', 'Budget report has been delete successfully!');
    }
}
