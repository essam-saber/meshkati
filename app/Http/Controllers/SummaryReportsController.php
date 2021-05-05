<?php

namespace App\Http\Controllers;

use App\AgingOfDebit;
use App\Budget;
use App\Inventory;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SummaryReportsController extends Controller
{
    public function index(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('read_reports')) abort(403);

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $showReport = false;
        if($date = request('date') ) {
            $showReport = true;
            [$month, $year] = explode('-', $date);
            $prevYear = Carbon::parse($year.'-'.$month)->subYear()->year;

            $actualSalesForCurrentMonth = Sale::where('year', $year)->where('month', $month)->first();
            $budgetSalesForCurrentMonth = Budget::where('year', $year)->where('month', $month)->first();
            $actualSalesForCurrentMonthPrevYear = Sale::where('year', $prevYear)->where('month', $month)->first();

            $agingOfDebits = AgingOfDebit::with(['attribute'])->where('year', $year)->where('month', $month)->get();
            $inventory = Inventory::where('year', $year)->where('month', $month)->first();

            return view('pages.reports.summary')->with([
                'showReport' => $showReport,
                'actualSalesForCurrentMonth' => $actualSalesForCurrentMonth,
                'actualSalesForCurrentMonthPrevYear' => $actualSalesForCurrentMonthPrevYear,
                'budgetSalesForCurrentMonth' => $budgetSalesForCurrentMonth,
                'agingOfDebit' => $agingOfDebits,
                'inventory' => $inventory,
                'page_title' => 'Monthly Summary Report'

            ]);
        }
        return view('pages.reports.summary', compact('showReport'));
    }

    private function getAgingOfDebit($year, $month)
    {

    }

    private function getInventoryDate($year, $month)
    {

    }
}
