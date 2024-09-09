<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_all_invoice', [InvoiceController::class, 'getAllInvoice']);
Route::get('/search_invoice', [InvoiceController::class, 'getSearchInvoice']);

Route::get('/api/customers', [CustomerController::class, 'getAllCustomers']);
Route::get('/api/create_invoice', [InvoiceController::class, 'createInvoice']);
