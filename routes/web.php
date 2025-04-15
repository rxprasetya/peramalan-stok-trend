<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForecastingController;

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


// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('alogin');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// User
Route::get('/user', [UserController::class, 'index'])->name('user')->middleware(['auth', 'admin']);

Route::get('/user/create-user', [UserController::class, 'create'])->name('cuser')->middleware(['auth', 'admin']);

Route::get('/user/edit-user/{id}', [UserController::class, 'edit'])->name('euser')->middleware(['auth', 'admin']);

Route::post('/user/create-user', [UserController::class, 'insert'])->name('iuser')->middleware(['auth', 'admin']);

Route::post('/user/edit-user/{id}', [UserController::class, 'update'])->name('uuser')->middleware(['auth', 'admin']);

Route::get('/user/{id}', [UserController::class, 'delete'])->name('duser')->middleware(['auth', 'admin']);

// Item
Route::get('/item', [ItemController::class, 'index'])->name('item')->middleware('auth');

Route::get('/item/create-item', [ItemController::class, 'create'])->name('citem')->middleware('auth');

Route::get('/item/import-item', [ItemController::class, 'import'])->name('imitem')->middleware('auth');

Route::get('/item/edit-item/{id}', [ItemController::class, 'edit'])->name('eitem')->middleware('auth');

Route::post('/item/create-item', [ItemController::class, 'insert'])->name('iitem')->middleware('auth');

Route::post('/item/import-item', [ItemController::class, 'pushImport'])->name('puitem')->middleware('auth');

Route::post('/item/edit-item/{id}', [ItemController::class, 'update'])->name('uitem')->middleware('auth');

Route::get('/item/{id}', [ItemController::class, 'delete'])->name('ditem')->middleware('auth');

// Stock
Route::get('/stock', [StockController::class, 'index'])->name('stock')->middleware('auth');

Route::get('/stock/create-stock', [StockController::class, 'create'])->name('cstock')->middleware('auth');

Route::get('/stock/import-stock', [StockController::class, 'import'])->name('imstock')->middleware('auth');

Route::get('/stock/edit-stock/{id}', [StockController::class, 'edit'])->name('estock')->middleware('auth');

Route::post('/stock/create-stock', [StockController::class, 'insert'])->name('istock')->middleware('auth');

Route::post('/stock/import-stock', [StockController::class, 'pushImport'])->name('pustock')->middleware('auth');

Route::post('/stock/edit-stock/{id}', [StockController::class, 'update'])->name('ustock')->middleware('auth');

Route::post('/stock/go-stock', [StockController::class, 'getOpening'])->name('gostock')->middleware('auth');

Route::get('/stock/{id}', [StockController::class, 'delete'])->name('dstock')->middleware('auth');

// Sale
Route::get('/sale', [SaleController::class, 'index'])->name('sale')->middleware('auth');

Route::get('/sale/create-sale', [SaleController::class, 'create'])->name('csale')->middleware('auth');

Route::get('/sale/import-sale', [SaleController::class, 'import'])->name('imsale')->middleware('auth');

Route::get('/sale/edit-sale/{id}', [SaleController::class, 'edit'])->name('esale')->middleware('auth');

Route::post('/sale/create-sale', [SaleController::class, 'insert'])->name('isale')->middleware('auth');

Route::post('/sale/import-sale', [SaleController::class, 'pushImport'])->name('pusale')->middleware('auth');

Route::post('/sale/edit-sale/{id}', [SaleController::class, 'update'])->name('usale')->middleware('auth');

Route::get('/sale/{id}', [SaleController::class, 'delete'])->name('dsale')->middleware('auth');

// Purchase
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase')->middleware('auth');

Route::get('/purchase/create-purchase', [PurchaseController::class, 'create'])->name('cpurchase')->middleware('auth');

Route::get('/purchase/import-purchase', [PurchaseController::class, 'import'])->name('impurchase')->middleware('auth');

Route::get('/purchase/edit-purchase/{id}', [PurchaseController::class, 'edit'])->name('epurchase')->middleware('auth');

Route::post('/purchase/create-purchase', [PurchaseController::class, 'insert'])->name('ipurchase')->middleware('auth');

Route::post('/purchase/import-purchase', [PurchaseController::class, 'pushImport'])->name('pupurchase')->middleware('auth');

Route::post('/purchase/edit-purchase/{id}', [PurchaseController::class, 'update'])->name('upurchase')->middleware('auth');

Route::get('/purchase/{id}', [PurchaseController::class, 'delete'])->name('dpurchase')->middleware('auth');

// Opname
Route::get('/opname', [OpnameController::class, 'index'])->name('opname')->middleware('auth');

Route::get('/opname/create-opname', [OpnameController::class, 'create'])->name('copname')->middleware('auth');

Route::get('/opname/import-opname', [OpnameController::class, 'import'])->name('imopname')->middleware('auth');

Route::post('/opname/gss-opname', [OpnameController::class, 'getSystemStock'])->name('gssopname')->middleware('auth');

Route::get('/opname/edit-opname/{id}', [OpnameController::class, 'edit'])->name('eopname')->middleware('auth');

Route::post('/opname/create-opname', [OpnameController::class, 'insert'])->name('iopname')->middleware('auth');

Route::post('/opname/import-opname', [OpnameController::class, 'pushImport'])->name('puopname')->middleware('auth');

Route::post('/opname/edit-opname/{id}', [OpnameController::class, 'update'])->name('uopname')->middleware('auth');

Route::get('/opname/export-opname', [OpnameController::class, 'export'])->name('exopname')->middleware('auth');

Route::get('/opname/template-opname', [OpnameController::class, 'export'])->name('topname')->middleware('auth');

Route::get('/opname/{id}', [OpnameController::class, 'delete'])->name('dopname')->middleware('auth');

// Forecasting
Route::get('/forecasting', [ForecastingController::class, 'index'])->name('forecasting')->middleware('auth');

Route::post('/tm-forecasting', [ForecastingController::class, 'trendMoment'])->name('tmforecasting')->middleware('auth');