<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
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

// Route::get('/', function () {
//     return view('welcome');
// });

//Category manage
Route::get('/', [HomeController::class, 'index'])->name('app.home');

Route::get('/create_category', [CategoryController::class, 'index'])->name('category.form');

Route::post('/create_category', [CategoryController::class, 'store_category']);

Route::get('/manage_category', [CategoryController::class, 'manage_category'])->name('category.manage');

Route::get('/manage_category/{id}/delete_category', [CategoryController::class, 'delete_category'])->name('category.delete');

Route::get('/manage_category/{id}/edit',[CategoryController::class,'edit_category'])->name('category.edit');

Route::put('/manage_category/{id}/edit',[CategoryController::class,'update_category'])->name('category.update');


//product manage
Route::get('/create_product',[ProductController::class,'index'])->name('product.form');

Route::post('/create_product',[ProductController::class,'store_product']);

Route::get('/manage_product', [ProductController::class, 'manage_product'])->name('product.manage');

Route::get('/manage_product/{id}/delete_product',[ProductController::class,'delete_product'])->name('product.delete');
