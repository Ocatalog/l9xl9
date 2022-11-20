<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HunterController;

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

Route::controller(HunterController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/zip', 'download');
    Route::get('/create', 'create');
    Route::get('/update/{id}', 'edit');
    Route::post('/create', 'store');
    Route::patch('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});