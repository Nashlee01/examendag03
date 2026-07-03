<?php

use App\Http\Controllers\BehandelingController;
use App\Http\Controllers\BehandelingProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/behandelingen', [BehandelingController::class, 'index'])->name('behandelingen.index');
    Route::get('/behandelingen/{behandeling}/edit', [BehandelingController::class, 'edit'])->name('behandelingen.edit');
    Route::put('/behandelingen/{behandeling}', [BehandelingController::class, 'update'])->name('behandelingen.update');

    Route::get('/behandelingen/{behandeling}/producten', [BehandelingProductController::class, 'index'])->name('behandelingen.producten.index');
    Route::get('/behandelingen/{behandeling}/producten/{product}', [BehandelingProductController::class, 'show'])->name('behandelingen.producten.show');
    Route::get('/behandelingen/{behandeling}/producten/{product}/wijzigen', [BehandelingProductController::class, 'edit'])->name('behandelingen.producten.edit');
    Route::put('/behandelingen/{behandeling}/producten/{product}', [BehandelingProductController::class, 'update'])->name('behandelingen.producten.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
