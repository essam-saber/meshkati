<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SalesReportsController extends Controller
{
    const ACTUAL_WITH_ACTUAL= '1';
    const ACTUAL_WITH_BUDGET= '2';

    public function salesAnalysisAndComparative(Request $request)
    {
        $firstYear = $request->first_date??Carbon::now()->year;
        $secondYear = $request->second_date??Carbon::now()->subYear()->year;
        $sales = Sale::where('year', $firstYear)
            ->orWhere('year', $secondYear)
            ->ascOrder()
            ->get()->groupBy(function($sale){
            return $sale['year'];
        });
        $firstYearSales =  Arr::get($sales,$firstYear) ?? collect();
        $secondYearSales = Arr::get($sales, $secondYear) ?? collect();
        return view('pages.reports.sales-analysis-comparative')->with([
            'page_title' => 'Sales Reports',
            'page_description' => 'Display Sales Reports And Filtering Them',
            'firstYear' => $firstYear,
            'secondYear' => $secondYear,
            'firstYearSales' => $firstYearSales,
            'secondYearSales' => $secondYearSales,
        ]);
    }

    public function salesAndGPBudget(Request $request)
    {
        $salesYear = $request->sales_year ?? Carbon::now()->year;
        $budgetYear = $request->budget_year??Carbon::now()->year;
        $actualSales = Sale::where('year', $salesYear)->ascOrder()->get();
        $budgetSales = Sale::where('year', $budgetYear)->ascOrder()->get();
        if($request->report_type === self::ACTUAL_WITH_BUDGET) {
            $budgetSales = Sale::where('year', $budgetYear)->ascOrder()->get();
        }
        return view('pages.reports.sales-gp-budget')->with([
            'page_title' => 'Sales Reports',
            'page_description' => 'Display Sales Reports And Filtering Them',
            'actualSales' => $actualSales,
            'budgetSales' => $budgetSales,
            'salesYear' => $salesYear,
            'budgetYear' => $budgetYear
        ]);
    }

    public function currentAndPriorYearSales(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $priorYear = Carbon::now()->subYear()->year;

        $currentYearSales = Sale::where('year', $currentYear)->get();
        $priorYearSales = Sale::where('year', $priorYear)->get();

        return view('pages.reports.sales-gp-budget-prior-year')->with([
            'page_title' => 'Sales Reports',
            'page_description' => 'Display Sales Reports And Filtering Them',
            'currentYearSales' => $currentYearSales,
            'priorYearSales' => $priorYearSales,
            'currentYear' => $currentYear,
            'priorYear' => $priorYear
        ]);
    }
}
