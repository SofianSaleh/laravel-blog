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

Route::get('/api/get_all_tags',[TagController::class, 'getAll']);
Route::post('/api/create_tag',[TagController::class, 'createTag']);
Route::get('{any}',[VueController::class, 'index'])->where('any', '.*');
