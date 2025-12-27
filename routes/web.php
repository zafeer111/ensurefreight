<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CustomerUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;
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
// welcome page

Route::get('/', function () {
    return redirect()->route('customer.login');
});
Route::get('/quote-mail', function () {
    return view('mail.quote-mail');
});

Route::get('/customer-login', [CustomerUserController::class, 'index'])->name('customer.login')->middleware('guest');
Route::get('/logout', [CustomerUserController::class, 'logout'])->name('logout');
Route::post('/customer-login', [CustomerUserController::class, 'login']);

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('update-password', [ForgotPasswordController::class, 'reset'])->name('password.update.submit');

//dashboard chart
Route::get('/chart', [ChartController::class, 'getChart'])->name('dashboard.chart');

Route::middleware(['auth.check'])->group(function () {

    Route::get('/customer/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');

    //user-settings
    Route::get('/user-setting', [CustomerUserController::class, 'setting'])->name('user.setting');
    Route::post('/upload-image', [CustomerUserController::class, 'uploadImage'])->name('upload.image');
    Route::post('/update-profile', [CustomerUserController::class, 'updateProfile'])->name('update.profile');
    Route::post('/reset-password', [CustomerUserController::class, 'resetPassword'])->name('reset.password');

    // Inquiry Module
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/create', [InquiryController::class, 'create'])->name('inquiries.create');
    Route::get('/inquiries/{id}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::post('/inquiries/store', [InquiryController::class, 'store'])->name('inquiries.store');
    Route::get('/inquiries/edit/{id}', [InquiryController::class, 'edit'])->name('inquiries.edit');
    Route::put('/inquiries/update/{id}', [InquiryController::class, 'update'])->name('inquiries.update');

    //Booking Module
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{booking_id}', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/generate-bol-pdf', [BookingController::class, 'generateBOLPDF'])->name('generate-bol-pdf');

    //Quotation Module
    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/{id}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::post('/quotations/store', [QuotationController::class, 'store'])->name('quotations.store');
    Route::put('/quotations/{quotationId}/lineitems/{lineItemId}/{status}', [QuotationController::class, 'updateStatus'])->name('quotations.update.status');

    Route::post('/download-quote', [QuotationController::class, 'downloadQuote'])->name('download-quote');

});

//Ajax Request for Dependent Region Selection
Route::get('/get-states/{countryId}', [InquiryController::class, 'getStates'])->name('get-states');
Route::get('/get-cities/{stateId}', [InquiryController::class, 'getCities'])->name('get-cities');
//Route::post('/get-names', [AddressController::class, 'getNames']);

//Address Modal Storing
Route::middleware(['auth'])->group(function () {

    //Address Module
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::get('/addresses/{id}', [AddressController::class, 'show'])->name('addresses.show');
    Route::post('/addresses/store', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
});

Route::get('/terms', function () {
    return view('terms&conditions.terms');
});
Route::get('/terms-and-conditions', function (){
    return view('terms&conditions.termsConditions');
})->name('termsConditions');;

Route::get('/login', function () {
    return redirect(route('filament.admin.auth.login'));
})->name('login');
