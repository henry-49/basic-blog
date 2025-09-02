<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BrandController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function () {
    echo "This is home page";
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact',[ContactController::class, 'index'])->name('contact');

//  Category All Route
Route::get('/category/all',[CategoryController::class, 'all_category'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'add_category'])->name('store.category');
Route::get('/category/edit/{id}',[CategoryController::class, 'edit_category'])->name('edit.category');
Route::post('/category/update/{id}',[CategoryController::class, 'update_category'])->name('update.category');
Route::get('/category/delete/{id}',[CategoryController::class, 'delete_category'])->name('delete.category');
Route::get('/category/restore/{id}',[CategoryController::class, 'restore_category'])->name('restore.category');
Route::get('/category/pdelete/{id}',[CategoryController::class, 'pdelete_category'])->name('pdelete.category');

// Brand All Route
Route::get('/brand/all',[BrandController::class, 'all_brand'])->name('all.brand');
Route::post('/brand/add',[BrandController::class, 'add_brand'])->name('store.brand');
Route::get('/brand/edit/{id}',[BrandController::class, 'edit_brand'])->name('edit.brand');
Route::post('/brand/update/{id}',[BrandController::class, 'update_brand'])->name('update.brand');
Route::get('/brand/delete/{id}',[BrandController::class, 'delete_brand'])->name('delete.brand');
Route::get('/brand/restore/{id}',[BrandController::class, 'restore_brand'])->name('restore.brand');
Route::get('/brand/pdelete/{id}',[BrandController::class, 'pdelete_brand'])->name('pdelete.brand');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // support diffForHumans() when displaying created_at
        // usage: $user->created_at->diffForHumans()
        //$users = User::all();
        
        // error: Call to a member function diffForHumans() on string
        // usage: Carbon\Carbon::parse($user->created_at)->diffForHumans()
        $users = DB::table('users')->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});