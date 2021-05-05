<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Http\Requests\StoreActualSalesRequest;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        if(!auth()->user()->hasPermissionTo('read_budget_sales')) abort(403);

        return view('pages.budget.index')->with([
            'page_title' => 'budget',
            'page_description' => 'Show all budget',
            'budget' => Budget::orderBy('year', 'desc')->orderBy('month', 'desc')->get()
        ]);
    }

    public function edit($id)
    {
        if(!auth()->user()->hasPermissionTo('edit_budget_sales')) abort(403);

        $budget = Budget::where('id', $id)->firstOrFail();
        return view('pages.budget.edit')->with([
            'page_title' => 'Edit Budget',
            'page_description' => 'Edit a particular Budget',
            'budget' => $budget
        ]);
    }

    public function update(StoreActualSalesRequest $request, $id)
    {
        if(!auth()->user()->hasPermissionTo('edit_budget_sales')) abort(403);

        [$month, $year] = explode('-',$request->month);
        $monthInsertedBefore = Budget::where('year', $year)->where('month', $month)->count();

        if($monthInsertedBefore > 1) {
            return back()->with(['error' => 'The budget for this month has been inserted before!, go to budget page if you want to edit']);
        }

        $data = $request->except('_token');



        $sale = Budget::where('id', $id)->firstOrFail();
        $data['year'] = $year;
        $data['month'] = $month;
        $sale->update($data);

        $sales = Budget::where('year', $year)->ascOrder()->get();

        foreach($sales as $key => $sale) {
            $prevKey = $key - 1;
            $sales[$key]->net_sales = ($sales[$key]->cash + $sales[$key]->credit) - $sales[$key]->returns;
            $sales[$key]->net_sales_cum = $key === 0 ? $sales[$key]->net_sales : $sales[$prevKey]->net_sales_cum + $sales[$key]->net_sales;
            $sales[$key]->gross_profit = $sales[$key]->net_sales - $sales[$key]->cost_of_sales;
            $sales[$key]->gross_profit_cum = $key === 0 ? $sales[$key]->gross_profit : $sales[$prevKey]->gross_profit_cum + $sales[$key]->gross_profit;
            $sales[$key]->gross_profit_percentage = round($sales[$key]->gross_profit / $sales[$key]->net_sales * 100,0);
            $sales[$key]->gross_profit_cum_percentage = round($sales[$key]->gross_profit_cum / $sales[$key]->net_sales_cum * 100, 0);
            $sales[$key]->net_profit = $sales[$key]->gross_profit - $sales[$key]->expenses;
            $sales[$key]->net_profit_cum = $key === 0 ? $sales[$key]->net_profit : $sales[$prevKey]->net_profit_cum + $sales[$key]->net_profit;
            $sales[$key]->net_profit_percentage = round($sales[$key]->net_profit / $sales[$key]->net_sales * 100, 0);
            $sales[$key]->net_profit_cum_percentage = round($sales[$key]->net_profit_cum / $sales[$key]->net_sales_cum * 100, 0);
            $sales[$key]->save();
        }

        return back()->with(['success' => 'Budget has been updated successfully']);
    }

    public function create()
    {
        if(!auth()->user()->hasPermissionTo('create_budget_sales')) abort(403);

        return view('pages.budget.create')->with([
            'page_title' => 'Create Monthly budget',
            'page_description' => 'Add new budget record for a particular month',
        ]);
    }

    public function store(StoreActualSalesRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create_budget_sales')) abort(403);

        [$month, $year] = explode('-',$request->month);

        $monthInsertedBefore = Budget::where('year', $year)->where('month', $month)->count();
        if($monthInsertedBefore > 0) {
            return back()->with(['error' => 'The sales for this month has been inserted before!, go to sales page if you want to edit']);
        }
        $lastInsertedMonth = Budget::where('year', $year)->descOrder()->first();
        $data = $request->except('_token');
        $data['year'] = $year;
        $data['month'] = $month;
        $data['user_id'] = auth()->id() ?? 1;
        $data['net_sales'] = ($data['cash'] + $data['credit']) - $data['returns'];
        $data['net_sales_cum'] = isset($lastInsertedMonth) ? $lastInsertedMonth->net_sales_cum + $data['net_sales'] : $data['net_sales'];
        $data['gross_profit'] = $data['net_sales'] - $data['cost_of_sales'];
        $data['gross_profit_cum'] = isset($lastInsertedMonth) ? $lastInsertedMonth->gross_profit_cum + $data['gross_profit'] : $data['gross_profit'];
        $data['gross_profit_percentage'] = round($data['gross_profit'] / $data['net_sales'] * 100, 0);
        $data['gross_profit_cum_percentage'] = round($data['gross_profit_cum'] / $data['net_sales_cum'] * 100,0);
        $data['net_profit'] = $data['gross_profit'] - $data['expenses'];
        $data['net_profit_cum'] = isset($lastInsertedMonth) ? $lastInsertedMonth->net_profit_cum + $data['net_profit'] : $data['net_profit'];
        $data['net_profit_percentage'] = round($data['net_profit'] / $data['net_sales'] * 100,0);
        $data['net_profit_cum_percentage'] = round($data['net_profit_cum'] / $data['net_sales_cum'] * 100, 0);

        Budget::create($data);
        session()->flash('success', 'Monthly budget Has Been Created Successfully !');
        return redirect()->route('budget.index');
    }

    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete_budget_sales')) abort(403);

        $Budget = Budget::where('id', $id)->firstOrFail();
        $Budget->delete();
        return back()->with('success', 'Budget report has been delete successfully!');
    }
}
