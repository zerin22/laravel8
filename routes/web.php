<?php

use App\Http\Controllers\ContactController;
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
});

Route::get('/home', function () {
    echo "This is home Page";
});

Route::get('/about', function () {
    return view('about');
})->middleware('check');

// Route::get('/contact', function () {
//     return view('contact');
// });

//Route With Using Controller
Route::get('/contact', [ContactController::class, 'index']);
