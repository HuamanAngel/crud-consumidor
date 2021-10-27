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

Route::post('/session/logout',[AuthController::class,'logout'])->name('logout.api');
Route::post('/api/register', [ArticlesController::class,'registerApi'])->name('registerApi');
Route::post('/loginProcess',[ArticlesController::class,'login'])->name('loginProcess');
Route::get('/show/articles',[ArticlesController::class,'showAll'])->name('showAllArticle');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('nuevo',function(){
    return view('nuevo');
});
Route::get('template',function(){
    return view('template');
});

Route::resource('articles', ArticleController::class);
