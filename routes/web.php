<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Storage;
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

Route::get('/', 'HomeController@index')->name('home');

// Login Routes
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
    
Route::get('/prescriptions/create', [PrescriptionController::class, 'create']);
Route::post('/prescriptions', [PrescriptionController::class, 'store']);

Route::get('/prescriptions/{id}/view', [PrescriptionController::class, 'view']);
   
Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    
Route::get('/storage/{filename}', function ($filename) {
    $path = Storage::path($filename);
    return response()->file($path);
})->where('filename', '.*');

Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');

Route::get('/prescriptions/{id}/quotation', [QuotationController::class, 'prepareQuotation']);
Route::post('/prescriptions/{id}/quotation', [QuotationController::class, 'storeQuotation']);

Route::post('/accept-quotation/{id}', 'QuotationController@acceptQuotation')->name('accept.quotation');
Route::post('/reject-quotation/{id}', 'QuotationController@rejectQuotation')->name('reject.quotation');

Route::get('/accepted_quotations', [QuotationController::class, 'accepted'])->name('quotations.accepted');
