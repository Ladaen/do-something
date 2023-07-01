<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Landing;

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
Route::get('/', [Landing::class,'land']);
Route::get('/home', [HomeController::class,'index']);
Route::get('/feeds', [HomeController::class,'feeds']);
Auth::routes();

Route::resource('activity', ActivityController::class);
// Route::group(['namespace' => 'activity', 'prefix' => 'activity'], function(){
//     Route::get('{id}/edit', ['as' => 'activity.edit', 'uses' => 'edit@ActivityController']);
// });

