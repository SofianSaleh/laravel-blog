<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VueController;
use App\Http\Controllers\TagController;

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
Route::get('{any}', [VueController::class, 'index'])->where('any', '.*');
