<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;

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
// Tag Routes Start

Route::get('/api/tag/get_all_tags', [TagController::class, 'getAll']);
Route::post('/api/tag/create_tag', [TagController::class, 'createTag']);
Route::post('/api/tag/edit_tag', [TagController::class, 'editTag']);
Route::post('/api/tag/delete_tag', [TagController::class, 'deleteTag']);

// Tag Routes finished

// Genral Routes Start

Route::post('/api/upload', [CategoryController::class, 'upload']);
Route::post('/api/remove_img', [CategoryController::class, 'removeImg']);

// Genral Routes finished

// Category Routes Start

Route::get('/api/category/get_all_categories', [CategoryController::class, 'getAll']);
Route::post('/api/category/add', [CategoryController::class, 'addCategory']);
Route::post('/api/category/edit', [CategoryController::class, 'editCategory']);
Route::post('/api/category/delete', [CategoryController::class, 'deleteCategory']);

// Category Routes finished

// Admin Routes Start

Route::get('/api/user/get_all', [AdminController::class, 'getUsers']);
Route::post('/api/user/create', [AdminController::class, 'createUser']);
Route::post('/api/user/edit', [AdminController::class, 'editUser']);
Route::post('/api/user/admin_login', [AdminController::class, 'adminLogin']);

// User Routes Finished

Route::get('{any}', [VueController::class, 'index'])->where('any', '.*');
