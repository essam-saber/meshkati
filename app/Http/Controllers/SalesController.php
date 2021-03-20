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
        $lastInsertedMonth = Sale::latest()->first();
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

        $sale = Sale::where('id', $id)->firstOrFail();
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

        if(Sale::count() > 1) {

            $sales = Sale::where('year', $year)->ascOrder()->get();
            foreach($sales as $key => $sale) {
                $data = [];
                $netSalesCum = $key !== 0 ? $sale->net_sales + $sales[$key-1]->net_sales_cum : $sale->net_sales;
                $grossProfit = $sale->net_sales - $sale->cost_of_sales;
                $grossProfitCum = $key !== 0 ? $sales[$key-1]->gross_profit_cum + $grossProfit : $grossProfit;
                $grossProfitPercentage = $grossProfit / $sale->net_sales * 100;
                $grossProfitCumPercentage = $grossProfitCum / $netSalesCum * 100;
                $netProfit =  $grossProfit - $sale->expenses;
                $netProfitPercentage = $netProfit / $sale->net_sales * 100;
                $netProfitCum =  $key !== 0 ? $sales[$key-1]->net_profit_cum + $netProfit : $netProfit;
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

        $lastInsertedMonth = Sale::latest()->first();
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
