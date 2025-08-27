<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
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

Route::get('/category/all',[CategoryController::class, 'all_category'])->name('all.category');
Route::post('/category/add',[CategoryController::class, 'add_category'])->name('store.category');
Route::get('/category/edit/{id}',[CategoryController::class, 'edit_category'])->name('edit.category');
Route::post('/category/update/{id}',[CategoryController::class, 'update_category'])->name('update.category');
Route::get('/category/delete/{id}',[CategoryController::class, 'delete_category'])->name('delete.category');
Route::get('/category/restore/{id}',[CategoryController::class, 'restore_category'])->name('restore.category');
Route::get('/category/pdelete/{id}',[CategoryController::class, 'pdelete_category'])->name('pdelete.category');

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