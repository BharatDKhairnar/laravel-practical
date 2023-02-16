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

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
});

// Users 
$controllerName = CompanyController::class;
Route::prefix('companies')->name('companies.')->group(function() use($controllerName) {
    Route::get('/create', [$controllerName, 'create'])->name('create');
    Route::post('/store', [$controllerName, 'store'])->name('store');
});

Route::middleware('auth')->prefix('companies')->name('companies.')->group(function() use($controllerName) {
    Route::get('/', [$controllerName, 'index'])->name('index');
});