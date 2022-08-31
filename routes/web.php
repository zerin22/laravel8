<?php

use App\Http\Controllers\CategoryController;
use app\Models\User;
use Illuminate\Support\Facades\DB;
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

//Category Controller
Route::get('/category/all',[CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'AddCat'])->name('store.category');

Route::get('/dashboard', function () {

   // $users= User::all();  //Read Users Data by Eloquent ORM

    $users = DB::table('users')->get();  //Read Users Data by Query Builder

    return view('dashboard', compact('users'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
