<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminCheck;

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

Route::prefix('api')->middleware(AdminCheck::class)->group(function () {

    // Tag Routes Start

    Route::get('/tag/get_all_tags', [TagController::class, 'getAll']);
    Route::post('/tag/create_tag', [TagController::class, 'createTag']);
    Route::post('/tag/edit_tag', [TagController::class, 'editTag']);
    Route::post('/tag/delete_tag', [TagController::class, 'deleteTag']);

    // Tag Routes finished

    // Genral Routes Start

    Route::post('/upload', [CategoryController::class, 'upload']);
    Route::post('/remove_img', [CategoryController::class, 'removeImg']);

    // Genral Routes finished

    // Category Routes Start

    Route::get('/category/get_all_categories', [CategoryController::class, 'getAll']);
    Route::post('/category/add', [CategoryController::class, 'addCategory']);
    Route::post('/category/edit', [CategoryController::class, 'editCategory']);
    Route::post('/category/delete', [CategoryController::class, 'deleteCategory']);

    // Category Routes finished

    // Admin Routes Start

    Route::get('/user/get_all', [AdminController::class, 'getUsers']);
    Route::post('/user/create', [AdminController::class, 'createUser']);
    Route::post('/user/edit', [AdminController::class, 'editUser']);
    // User Routes Finished
});

Route::post('/api/user/admin_login', [AdminController::class, 'adminLogin']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::get('/', [AdminController::class, 'index']);
Route::any('{any}', [AdminController::class, 'index']);
// ->where('any', '.*');
