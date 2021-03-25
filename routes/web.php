<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/login', [Login::class, 'login']);
Route::get('/logout', [Login::class, 'logout']);
Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::get('/', [Login::class, 'index']);
    Route::get('/dashboard', [Login::class, 'dashboard']);
});
