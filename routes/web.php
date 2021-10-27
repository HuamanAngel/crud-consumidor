<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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
    return view('welcome');
})->name("newHome");

Route::post('/registerApi', [AuthController::class,'registerApi'])->name('registerApi');
Route::post('/loginProcess',[AuthController::class,'login'])->name('loginProcess');
Route::middleware(['auth.api.verified'])->group(function () {
    Route::post('/session/logout',[AuthController::class,'logout'])->name('logout.api');
    Route::resource('articles', ArticleController::class);
});
Auth::routes();