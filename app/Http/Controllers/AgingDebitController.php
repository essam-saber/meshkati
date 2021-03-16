<?php

namespace App\Http\Controllers;

use App\AgingAttribute;
use App\AgingOfDebit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgingDebitController extends Controller
{
    public function index()
    {
        $agingAttributes = AgingAttribute::all();
        $agings = AgingOfDebit::ascOrder()->with(['attribute'])->get()->groupBy(function($item, $key){
            return $item['year'].'-'.$item['month'];

        });
        return view('pages.aging.index')->with([
            'page_title' => 'Browse Inventory',
            'attributes' => $agingAttributes,
            'agingDebits' => $agings
        ]);
    }

    public function create()
    {
        $agingAttributes = AgingAttribute::all();
        return view('pages.aging.create')->with([
            'page_title' => 'Create new aging of debit',
            'attributes' => $agingAttributes,
        ]);
    }

    public function store(Request $request)
    {
        [$month, $year] = explode('-', $request->month);
        $data = $request->only('attributes');
        $attributeValues =  $data['attributes'];

        $recordExists = AgingOfDebit::where('year', $year)->where('month', $month)->count();
        if($recordExists) {
            return back()->with('error', 'The inserted month is already exists, please go to aging of debit page and edit it');
        }
        foreach($attributeValues as $key => $value) {
            AgingOfDebit::create([
                'year' => $year,
                'month' => $month,
                'attribute_id' => $key,
                'value' => $value,
                'user_id' => auth()->id() ?? 1
            ]);
        }
        return redirect()->route('aging-of-debit.index')->with('success', 'The data has been inserted successfully !');
    }

    public function edit($year, $month){
        $agings = AgingOfDebit::where('year', $year)->where('month', $month)->get()->groupBy(function($ag){
            return $ag->attribute_id;
        });
        $agingAttributes = AgingAttribute::all();

        return view('pages.aging.edit')->with([
            'agings' => $agings,
            'page_title' => 'Edit aging of debit',
            'attributes' => $agingAttributes,
            'date' => $year.'-'.$month
        ]);
    }
    public function update(Request $request, $year, $month)
    {
        AgingOfDebit::where('year', $year)->where('month', $month)->delete();
        $data = $request->only('attributes');
        $attributeValues =  $data['attributes'];
        $recordExists = AgingOfDebit::where('year', $year)->where('month', $month)->count();
        if($recordExists > 1) {
            return back()->with('error', 'The inserted month is already exists, please go to aging of debit page and edit it');
        }
        foreach($attributeValues as $key => $value) {
            AgingOfDebit::create([
                'year' => $year,
                'month' => $month,
                'attribute_id' => $key,
                'value' => $value,
                'user_id' => auth()->id() ?? 1
            ]);
        }
        return redirect()->route('aging-of-debit.index')->with('success', 'The data has been inserted successfully !');
    }
    public function destroy($year, $month)
    {
        AgingOfDebit::where('year', $year)->where('month', $month)->delete();
        return back()->with(['success' => 'Data has been deleted successfully']);
//        $inventory = Inventory::where('id', $id)->firstOrFail();
//        $inventory->delete();
//        return redirect()->route('inventory.index')->with(['success' => 'Inventory record has been deleted successfully']);
    }
}
