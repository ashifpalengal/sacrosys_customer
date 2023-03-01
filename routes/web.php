<?php

use App\Http\Controllers\CustomerController;
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

Route::get('/', [CustomerController::class, 'viewCustomer'])->name('customer.viewCustomer');
Route::get('/get-customers-data', [CustomerController::class, 'getCustomersData'])->name('customer.getCustomersData');
Route::get('/add-customer-view', [CustomerController::class, 'viewAddCustomer'])->name('customer.viewAddCustomer');
Route::post('/add-new-customer', [CustomerController::class, 'addNewCustomer'])->name('customer.addNewCustomer');
Route::get('/edit-customer/{id}', [CustomerController::class, 'editCustomer'])->name('customer.editCustomer');
Route::post('/update-customer', [CustomerController::class, 'updateCustomer'])->name('customer.updateCustomer');
Route::get('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('customer.deleteCustomer');

Route::get('/states/{country_id}', [CustomerController::class, 'getStates'])->name('customer.getStates');
Route::get('/country/{country_id}', [CustomerController::class, 'getCountry'])->name('customer.getCountry');

Route::get('/activate-customer/{id}', [CustomerController::class, 'activateCustomer'])->name('customer.activateCustomer');



// Route::get('/test', [CustomerController::class, 'test'])->name('customer.test');

