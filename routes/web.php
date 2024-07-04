<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route::get('/halo/{nama}', function ($nama) {
//     echo 'Halo Ketua,' . $nama;
// });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // Route untuk menu user
    Route::prefix('users')->group(function () {
            // tampilan semua user (index)
        Route::get('/index', [UserController::class, 'index'])->name('users.index');

        // tambah user baru (create)
        Route::get('/create', [UserController::class, 'create'])->name('users.create');

        // simpan user baru (store)
        Route::post('/store', [UserController::class, 'store'])->name('users.store');

        // ubah user yang ada (edit)
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

        // ubah user yang ada
        Route::post('/update', [UserController::class, 'update'])->name('users.update');

        // hapus user (delete)
        Route::post('/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    });
});


