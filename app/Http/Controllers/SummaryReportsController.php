<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SummaryReportsController extends Controller
{
    public function index(Request $request)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        if($date = $request->has('date') ) {

        }
        return view('pages.reports.summary');
    }

    private function getAgingOfDebit($year, $month)
    {

    }

    private function getInventoryDate($year, $month)
    {

    }
}
