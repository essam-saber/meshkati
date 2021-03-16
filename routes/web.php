<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'postLogin'])->name('postLogin');

Route::group(['middleware' => 'auth'], function(){

    Route::get('/', 'PagesController@index');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


// Demo routes
    Route::get('/datatables', 'PagesController@datatables');
    Route::get('/ktdatatables', 'PagesController@ktDatatables');
    Route::get('/select2', 'PagesController@select2');
    Route::get('/jquerymask', 'PagesController@jQueryMask');
    Route::get('/icons/custom-icons', 'PagesController@customIcons');
    Route::get('/icons/flaticon', 'PagesController@flaticon');
    Route::get('/icons/fontawesome', 'PagesController@fontawesome');
    Route::get('/icons/lineawesome', 'PagesController@lineawesome');
    Route::get('/icons/socicons', 'PagesController@socicons');
    Route::get('/icons/svg', 'PagesController@svg');

// Quick search dummy route to display html elements in search dropdown (header search)
    Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');

// Sales
    Route::get('sales', [\App\Http\Controllers\SalesController::class, 'index'])->name('sales.index');
    Route::post('sales', [\App\Http\Controllers\SalesController::class, 'store'])->name('sales.store');
    Route::get('sales/create', [\App\Http\Controllers\SalesController::class, 'create'])->name('sales.create');
    Route::get('sales/{id}/edit', [\App\Http\Controllers\SalesController::class, 'edit'])->name('sales.edit');
    Route::put('sales/{id}', [\App\Http\Controllers\SalesController::class, 'update'])->name('sales.update');
    Route::delete('sales/{id}', [\App\Http\Controllers\SalesController::class, 'destroy'])->name('sales.destroy');

// Budget
    Route::get('budget', [\App\Http\Controllers\BudgetController::class, 'index'])->name('budget.index');
    Route::post('budget', [\App\Http\Controllers\BudgetController::class, 'store'])->name('budget.store');
    Route::get('budget/create', [\App\Http\Controllers\BudgetController::class, 'create'])->name('budget.create');
    Route::get('budget/{id}/edit', [\App\Http\Controllers\BudgetController::class, 'edit'])->name('budget.edit');
    Route::put('budget/{id}', [\App\Http\Controllers\BudgetController::class, 'update'])->name('budget.update');
    Route::delete('budget/{id}', [\App\Http\Controllers\BudgetController::class, 'destroy'])->name('budget.destroy');


// Expenses
    Route::get('sales/expenses/create', [\App\Http\Controllers\ExpensesController::class, 'create'])->name('sales.expenses.create');
    Route::post('sales/expenses', [\App\Http\Controllers\ExpensesController::class, 'store'])->name('sales.expenses.store');


// Reports
    Route::get('/reports/sales-analysis-and-comparative', [\App\Http\Controllers\SalesReportsController::class, 'salesAnalysisAndComparative'])->name('reports.sales-analysis-and-comparative');
    Route::get('/reports/sales-and-gp-budget', [\App\Http\Controllers\SalesReportsController::class, 'salesAndGPBudget'])->name('reports.sales-and-gp-budge');
    Route::get('/reports/sales-and-gp-budget-prior-year', [\App\Http\Controllers\SalesReportsController::class, 'currentAndPriorYearSales']);
    Route::get('/reports/summary', [\App\Http\Controllers\SummaryReportsController::class, 'index'])->name('reports.summary');
// Inventory
    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class , 'index'])->name('inventory.index');
    Route::get('/inventory/{id}/edit', [\App\Http\Controllers\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::get('/inventory/create', [\App\Http\Controllers\InventoryController::class , 'create'])->name('inventory.create');
    Route::post('/inventory', [\App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{id}', [\App\Http\Controllers\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [\App\Http\Controllers\InventoryController::class, 'destroy'])->name('inventory.destroy');

// Aging
    Route::get('/aging-of-debit', [\App\Http\Controllers\AgingDebitController::class , 'index'])->name('aging-of-debit.index');
    Route::get('/aging-of-debit/{year}/{month}/edit', [\App\Http\Controllers\AgingDebitController::class, 'edit'])->name('aging-of-debit.edit');
    Route::get('/aging-of-debit/create', [\App\Http\Controllers\AgingDebitController::class , 'create'])->name('aging-of-debit.create');
    Route::post('/aging-of-debit', [\App\Http\Controllers\AgingDebitController::class, 'store'])->name('aging-of-debit.store');
    Route::put('/aging-of-debit/{year}/{month}', [\App\Http\Controllers\AgingDebitController::class, 'update'])->name('aging-of-debit.update');
    Route::delete('/aging-of-debit/{year}/{month}', [\App\Http\Controllers\AgingDebitController::class, 'destroy'])->name('aging-of-debit.destroy');


});