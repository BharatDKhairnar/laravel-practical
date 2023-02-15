<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

// Users 
$controllerName = CompanyController::class;
Route::prefix('companies')->name('companies.')->group(function() use($controllerName) {
    Route::get('/create', [$controllerName, 'create'])->name('create');
    Route::post('/store', [$controllerName, 'store'])->name('store');
});

Route::middleware('auth')->prefix('companies')->name('companies.')->group(function() use($controllerName) {
    Route::get('/', [$controllerName, 'index'])->name('index');
    Route::get('/edit/{user}', [$controllerName, 'edit'])->name('edit');
    Route::put('/update/{user}', [$controllerName, 'update'])->name('update');
    Route::delete('/delete/{user}', [$controllerName, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [$controllerName, 'updateStatus'])->name('status');

    
    Route::get('/import-users', [$controllerName, 'importUsers'])->name('import');
    Route::post('/upload-users', [$controllerName, 'uploadUsers'])->name('upload');

    Route::get('export/', [$controllerName, 'export'])->name('export');

});

Route::get('/company/dashboard', [$controllerName, 'dashboard'])->name('company-dashboard');