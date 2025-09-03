<?php

use Illuminate\Support\Facades\{Route, DB};
use App\Http\Controllers\{AdminController, ContactController, BrandController, CategoryController, MultiImageController};
use App\Models\User;
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


// Email Verification Notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    return view('home', compact('brands'));
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


// Multi Image All Route
Route::get('/multi/image',[MultiImageController::class, 'multi_image'])->name('multi.image');
Route::post('/multi/add',[MultiImageController::class, 'add_multi_image'])->name('store.multi.image');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // support diffForHumans() when displaying created_at
        // usage: $user->created_at->diffForHumans()
        //$users = User::all();

        // error: Call to a member function diffForHumans() on string
        // usage: Carbon\Carbon::parse($user->created_at)->diffForHumans()
        // $users = DB::table('users')->get();

        return view('admin.index');
    })->name('dashboard');
});
Route::get('/user/logout', [AdminController::class, 'logout'])->name('user.logout');