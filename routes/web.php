<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Posts;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController; // Correct import
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RandomProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartUserController;



Route::middleware(['web'])->group(function () {
    // Ваши маршруты здесь
    Route::get('/', function () {
        return view('welcome');
    });
});



// Ваши существующие маршруты
Route::get('/', [RandomProductsController::class, 'index'])->name('home');
Route::get('/bd', [Posts::class, 'bd'])->name('bd');
Route::post('/add_to_oils/{товар_id}', [Posts::class, 'addToOils'])->name('addToOils');
Route::post('/importNomenclature', [ImportController::class, 'importNomenclature'])->name('importNomenclature');
Route::post('/save_category/{товар_id}', [Posts::class, 'saveCategory']);
Route::post('/save_image/{товар_id}', [Posts::class, 'saveImage']);

// Маршруты аутентификации
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Маршруты администрирования (требуют аутентификации и роли admin)
Route::middleware(['auth'])->group(function () {
    

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
});

Route::get('/oils', [CategoryController::class, 'oils'])->name('oils');
Route::get('/tools', [CategoryController::class, 'tools'])->name('tools');
Route::get('/fasteners', [CategoryController::class, 'fasteners'])->name('fasteners');
Route::get('/mtz', [CategoryController::class, 'mtz'])->name('mtz');
Route::get('/gazel', [CategoryController::class, 'gazel'])->name('gazel');
Route::get('/autoСhemistry', [CategoryController::class, 'autoСhemistry'])->name('autoСhemistry');
Route::get('/autoVaz', [CategoryController::class, 'autoVaz'])->name('autoVaz');
Route::get('/ural', [CategoryController::class, 'ural'])->name('ural');
Route::get('/kamaz', [CategoryController::class, 'kamaz'])->name('kamaz');

Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');


Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/cart', [CartUserController::class, 'index'])->name('cart.index');


Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');


//Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');