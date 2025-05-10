<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Card;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller;
use App\Models\cards;
use App\Http\Controllers\UserRelatedController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\NatureController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/features', function () {
    return view('features');
});

Route::get('/About', function () {
    return view('About');
});

Route::get('/Contact', function () {
    return view('Contact');
});

Route::get('/Nav', function () {
    return view('layouts.Nav');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');




Route::get('/natures', [NatureController::class, 'index'])->name('natures.index')->middleware('auth');
Route::get('/naturesCreate', [NatureController::class, 'create'])->name('natures.create')->middleware('auth');
Route::post('/natures', [NatureController::class, 'store'])->name('natures.store')->middleware('auth');
Route::get('/natures/{nature}/edit', [NatureController::class, 'edit'])->name('natures.edit')->middleware('auth');

Route::put('/natures/{nature}', [NatureController::class, 'update'])->name('natures.update')->middleware('auth');
Route::delete('/natures/{nature}', [NatureController::class, 'destroy'])->name('natures.destroy')->middleware('auth');

Route::get('/budgets', [budgetController::class, 'index'])->name('budgets.index')->middleware('auth');
Route::get('/budgetsReccurring', [BudgetController::class, 'Recurrings'])->name('budgets.Recurring')->middleware('auth');

Route::get('/budgetsCreate', [BudgetController::class, 'create'])->name('budgets.create')->middleware('auth');
Route::post('/budgetsUpdate', [BudgetController::class, 'store'])->name('budgets.store')->middleware('auth');
Route::get('/budgets/{budget}', [BudgetController::class, 'show'])->name('budgets.show')->middleware('auth');
Route::get('/budgetsEdit{budget}', [BudgetController::class, 'edit'])->name('budgets.edit')->middleware('auth');
Route::post('/budgets', [BudgetController::class, 'update'])->name('budgets.update')->middleware('auth');
Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy')->middleware('auth');
Route::put('/budgets/{budget}', [BudgetController::class, 'Finalized'])->name('budgets.Finalized')->middleware('auth');


use App\Http\Controllers\BudgetSubitems;
use App\Http\Controllers\HoldingController;
use App\Http\Controllers\MasterXController;
use App\Http\Controllers\ReportsController;

Route::get('/budget_subitems', [BudgetSubitems::class, 'index'])->name('budget_subitems.index')->middleware('auth');
Route::get('/budget_subitems/create', [BudgetSubitems::class, 'create'])->name('budget_subitems.create')->middleware('auth');
Route::post('/budget_subitems', [BudgetSubitems::class, 'store'])->name('budget_subitems.store')->middleware('auth');
Route::get('/budget_subitems/{subitem}/edit', [BudgetSubitems::class, 'edit'])->name('budget_subitems.edit')->middleware('auth');
Route::put('/budget_subitems/{subitem}', [BudgetSubitems::class, 'update'])->name('budget_subitems.update')->middleware('auth');
Route::delete('/budget_subitems/{subitem}', [BudgetSubitems::class, 'destroy'])->name('budget_subitems.destroy')->middleware('auth');






Route::get('/categories', 'App\http\Controllers\CategoryController@index')->name('categories.index')->middleware('auth');
Route::get('/categoriesCreate', 'App\http\Controllers\CategoryController@create')->name('categories.create')->middleware('auth');
Route::post('/categories/store',  'App\http\Controllers\CategoryController@store')->name('categories.store')->middleware('auth');
Route::get('/categories/{category}/edit', 'App\http\Controllers\CategoryController@edit')->name('categories.edit')->middleware('auth');
Route::put('/categories/{category}','App\http\Controllers\CategoryController@update')->name('categories.update')->middleware('auth');
Route::delete('/categories/{category}', 'App\http\Controllers\CategoryController@destroy')->name('categories.destroy')->middleware('auth');




use App\Http\Controllers\TransactionController;
use App\Http\Controllers\XItemController;

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index')->middleware('auth');
Route::get('/transactionhistory', [TransactionController::class, 'Dashboard'])->name('transactions.list')->middleware('auth');
Route::get('/download', [TransactionController::class, 'download'])->name('transactions.download')->middleware('auth');


Route::get('/transactionsCreate', [TransactionController::class, 'create'])->name('transactions.create')->middleware('auth');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store')->middleware('auth');
Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit')->middleware('auth');
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update')->middleware('auth');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy')->middleware('auth');





Route::get('/cards', [Card::class, 'index'])->name('cards.index')->middleware('auth');
Route::get('/cardsCreate', [Card::class, 'create'])->name('cards.create')->middleware('auth');
Route::post('/cards', [Card::class, 'store'])->name('cards.store')->middleware('auth');
Route::get('/cards/{card}', [Card::class, 'show'])->name('cards.show')->middleware('auth');
Route::get('/cards/{card}/edit', [Card::class, 'edit'])->name('cards.edit')->middleware('auth');
Route::put('/cards/{card}', [Card::class, 'update'])->name('cards.update')->middleware('auth');
Route::delete('/cards/{card}', [Card::class, 'destroy'])->name('cards.destroy')->middleware('auth');

Route::get('/user_related', [UserRelatedController::class, 'index'])->name('user_related.index')->middleware('auth');
Route::get('/user_Create', [UserRelatedController::class, 'create'])->name('user_related.create')->middleware('auth');
Route::post('/user_related', [UserRelatedController::class, 'store'])->name('user_related.store')->middleware('auth');
Route::get('/user_related/{userRelated}/edit', [UserRelatedController::class, 'edit'])->name('user_related.edit')->middleware('auth');
Route::put('/user_related/{userRelated}', [UserRelatedController::class, 'update'])->name('user_related.update')->middleware('auth');
Route::delete('/user_related/{userRelated}', [UserRelatedController::class, 'destroy'])->name('user_related.destroy')->middleware('auth');


Route::get('/Profile',[ProfileController::class,'index'])->name('profile.index')->middleware('auth');

Route::get('/GoalsMatter',[GoalsController::class,'Goals'])->name('Goals.Matter')->middleware('auth');
Route::get('/goals', [GoalsController::class, 'index'])->name('goals.index')->middleware('auth');
Route::get('/CreateGoals', [GoalsController::class, 'create'])->name('goals.create')->middleware('auth');
Route::post('/Goals', [GoalsController::class, 'store'])->name('goals.save')->middleware('auth');

Route::get('/ModifyGoals{goal}', [GoalsController::class, 'edit'])->name('goals.edit')->middleware('auth');
Route::put('/AdjustGoals{goal}', [GoalsController::class, 'update'])->name('goals.update')->middleware('auth');
Route::delete('/goals/{goal}', [GoalsController::class, 'destroy'])->name('goals.destroy')->middleware('auth');
Route::put('/GoalsMilestones{goal}', [GoalsController::class, 'show'])->name('goals.show')->middleware('auth');
Route::get('/GoalsBalance', [GoalsController::class, 'UpdateBalance'])->name('goals.Balance')->middleware('auth');

Route::get('/SpendingReport',[ReportsController::class,'index'])->name('Report.spending')->middleware('auth');
Route::get('/CashBudgetReport',[ReportsController::class,'CashBudget'])->name('forecast')->middleware('auth');
Route::get('/BalanceSheet',[ReportsController::class,'Balancesheet'])->name('Balancesheet')->middleware('auth');
Route::get('/T-Balance{id}',[ReportsController::class,'show'])->name('T-Balance')->middleware('auth');


Route::get('/Master',[MasterXController::class,'create'])->name('Master')->middleware('auth');
Route::post('/Master', [MasterXController::class, 'store'])->name('masterx.store')->middleware('auth');
Route::post('/goals', [MasterXController::class, 'store'])->name('section.store')->middleware('auth');
Route::get('/MasterIndex', [MasterXController::class, 'index'])->name('master.index')->middleware('auth');
Route::get('/MasterShow{id}', [MasterXController::class, 'show'])->name('master.show')->middleware('auth');







Route::get('/Section',[XItemController::class,'create'])->name('section')->middleware('auth');
Route::post('/Sections',[XItemController::class,'store'])->name('x_items.store')->middleware('auth');
Route::get('/Updating{id}',[XItemController::class,'edit'])->name('section.edit')->middleware('auth');
Route::post('/UpdateItems',[XItemController::class,'update'])->name('section.update')->middleware('auth');
Route::delete('/deleting{id}',[XItemController::class,'destroy'])->name('section.delete')->middleware('auth');
Route::resource('x_items', XItemController::class);


Route::get('/Holding', [HoldingController::class, 'create'])->name('holding.create')->middleware('auth');
Route::post('/Holdings', [HoldingController::class, 'store'])->name('holding.store')->middleware('auth');
Route::post('/Holding', [HoldingController::class, 'update'])->name('holding.update')->middleware('auth');

Route::get('/Admin_Dash',[AdminController::class,'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/Admin_Users',[AdminController::class,'Users'])->name('admin.users')->middleware('auth');
Route::get('/online-users',[AdminController::class,'Onlineusers'])->name('admin.online');