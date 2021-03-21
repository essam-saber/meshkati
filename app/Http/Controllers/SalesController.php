<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Http\Requests\StoreActualSalesRequest;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::orderBy('year', 'desc')->orderBy('month', 'desc')->get();

        return view('pages.sales.index')->with([
            'page_title' => 'Sales',
            'page_description' => 'Show all sales',
            'sales' => $sales
        ]);
    }

    public function edit($id)
    {
        $sale = Sale::where('id', $id)->firstOrFail();
        return view('pages.sales.edit')->with([
            'page_title' => 'Edit Sale',
            'page_description' => 'Edit a particular sale',
            'sale' => $sale
        ]);
    }

    public function update(StoreActualSalesRequest $request, $id)
    {

        [$month, $year] = explode('-',$request->month);
        $monthInsertedBefore = Sale::where('year', $year)->where('month', $month)->count();

        if($monthInsertedBefore > 1) {
            return back()->with(['error' => 'The sales for this month has been inserted before!, go to sales page if you want to edit']);
        }


        $data = $request->except('_token');
        $sale = Sale::where('id', $id)->firstOrFail();
        $data['year'] = $year;
        $data['month'] = $month;
        $sale->update($data);

        $sales = Sale::where('year', $year)->ascOrder()->get();

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

        return back()->with(['success' => 'Sale has been updated successfully']);
    }

    public function create()
    {
        return view('pages.sales.create')->with([
            'page_title' => 'Create Monthly Sales',
            'page_description' => 'Add new sales record for a particular month',
        ]);
    }

    public function store(StoreActualSalesRequest $request)
    {
        [$month, $year] = explode('-',$request->month);
        $monthInsertedBefore = Sale::where('year', $year)->where('month', $month)->count();
        if($monthInsertedBefore > 0) {
            return back()->with(['error' => 'The sales for this month has been inserted before!, go to sales page if you want to edit']);
        }

        $lastInsertedMonth = Sale::where('year', $year)->descOrder()->first();
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

        Sale::create($data);

        session()->flash('success', 'Monthly Sales Report Has Been Created Successfully !');

        return redirect()->route('sales.index');
    }

    public function destroy($id)
    {
        $sale = Sale::where('id', $id)->firstOrFail();
        $sale->delete();
        return back()->with('success', 'Sale report has been delete successfully!');
    }
}
