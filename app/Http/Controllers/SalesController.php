<?php

namespace App\Http\Controllers;

use App\Budget;
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
        $monthInsertedBefore = Sale::where('year', $year)->where('month', $month)->count();

        if($monthInsertedBefore > 1) {
            return back()->with(['error' => 'The sales for this month has been inserted before!, go to sales page if you want to edit']);
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

        $sale = Sale::where('id', $id)->firstOrFail();

        $sale->update($data);

        if(Sale::count() > 1) {
            $data = [];
            $budgets = Sale::orderBy('year', 'asc')->orderBy('month', 'asc')->where('year', $year)->get();

            foreach($budgets as $key => $saleObject) {
                $grossProfit = $saleObject->net - $saleObject->cost_of_sales;
                $netProfit =  $grossProfit - $saleObject->expenses;
                $netSalesCum =$key === 0 ? $saleObject->net : $saleObject->net + $budgets[$key-1]->net;
                $netProfitPercentage = $netProfit / $netSalesCum * 100;
                $grossProfitPercentage = $grossProfit / $saleObject->net * 100;
                $grossProfitCum = $key === 0 ? $grossProfit: $saleObject->g_profit_cum + $grossProfit;
                $grossProfitCumPercentage = $netProfit / $netSalesCum * 100;
                $data['g_profit'] = $grossProfit;
                $data['g_profit_percentage'] = $grossProfitPercentage;
                $data['net_profit'] = $netProfit;
                $data['net_sales_cum'] = $netSalesCum;
                $data['net_profit_percentage'] = $netProfitPercentage;
                $data['g_profit_cum_percentage'] = $grossProfitCumPercentage;
                $data['g_profit_cum'] = $grossProfitCum;
                $saleObject->update($data);
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

        $monthInsertedBefore = Sale::where('year', $year)->where('month', $month)->count();
        if($monthInsertedBefore > 0) {
            return back()->with(['error' => 'The sales for this month has been inserted before!, go to sales page if you want to edit']);
        }

        $data = $request->except('_token');
        $grossProfit = $data['net'] - $data['cost_of_sales'];
        $lastInsertedMonth = Sale::latest()->first();
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
