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

Route::get('/', 'PagesController@index');


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
