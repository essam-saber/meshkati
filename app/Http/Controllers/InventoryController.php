<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryRequest;
use App\Inventory;
use App\InventoryAttribute;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::ascOrder()->get();
        return view('pages.inventory.index')->with([
            'page_title' => 'Browse Inventory',
            'inventories' => $inventories
        ]);
    }

    public function create()
    {
        return view('pages.inventory.create')->with([
            'page_title' => 'Create new record'
        ]);
    }

    public function store(StoreInventoryRequest $request)
    {
        [$month, $year] = explode('-', $request->month);
        $data = $request->except('_token', 'month');
        $data['month'] = $month;
        $data['year'] = $year;
        $recordExists = Inventory::where('year', $year)->where('month', $month)->count();
        if($recordExists) {
            return back()->with('error', 'The inserted month is already exists, please go to inventory and editing it');
        }
        Inventory::create($data);
        return redirect()->route('inventory.index')->with('success', 'The data has been inserted successfully !');
    }

    public function edit($id){
        $inventory = Inventory::where('id', $id)->firstOrFail();
        return view('pages.inventory.edit', compact('inventory'))
            ->with(['page_title' => 'edit inventory record ']);
    }
    public function update(StoreInventoryRequest $request, $id)
    {
        [$month, $year] = explode('-', $request->month);
        $data = $request->except('_token', 'month');
        $data['month'] = $month;
        $data['year'] = $year;
        $recordExists = Inventory::where('year', $year)->where('month', $month)->count();
        if($recordExists > 1) {
            return back()->with('error', 'The inserted month is already exists, please go to inventory and editing it');
        }
        $inventory = Inventory::where('id', $id)->firstOrFail();
        $inventory->update($data);
        return back()->with('success', 'Inventory record has been updated successfully');
    }
    public function destroy($id)
    {
        $inventory = Inventory::where('id', $id)->firstOrFail();
        $inventory->delete();
        return redirect()->route('inventory.index')->with(['success' => 'Inventory record has been deleted successfully']);
    }
}
