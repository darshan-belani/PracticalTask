<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/add-blog', [BlogController::class, 'add'])->name('addBlog');
    Route::post('/store-blog', [BlogController::class, 'store'])->name('storeBlog');
    Route::get('/list', [BlogController::class, 'blogList'])->name('list');
    Route::get('/view/{id}', [BlogController::class, 'view'])->name('view');
});