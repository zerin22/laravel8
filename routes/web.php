<?php

use App\Http\Controllers\BrandController;
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

//Category Controller Route
Route::get('/category/all',[CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'AddCat'])->name('store.category');

//Category Edit
Route::get('/category/edit/{id}',[CategoryController::class, 'Edit']);
Route::post('/category/update/{id}',[CategoryController::class, 'Update']);

//SoftDelete Category
Route::get('/softdelete/category/{id}',[CategoryController::class, 'SoftDelete']);

//Restore Category
Route::get('/category/restore/{id}',[CategoryController::class, 'Restore']);

//Parmanent Delete
Route::get('/category/pdelete/{id}',[CategoryController::class, 'Pdelete']);

//Brand Controller Route
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');

Route::post('/brand/add', [BrandController::class, 'StoreBrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'Edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'Update']);
Route::get('/brand/delete/{id}', [BrandController::class, 'Delete']);

//Multi Image Route
Route::get('/multi/image', [BrandController::class, 'MultiImage'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'StrorImg'])->name('store.image');



Route::get('/dashboard', function () {

   // $users= User::all();  //Read Users Data by Eloquent ORM

    $users = DB::table('users')->get();  //Read Users Data by Query Builder

    return view('admin.index ');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
