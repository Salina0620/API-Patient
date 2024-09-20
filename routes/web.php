<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use OpenApi\Annotations as OA;

Route::get('/documentation/api-docs.json', function () {
    return response()->json(\OpenApi\Generator::scan([app_path('Http/Controllers/API')]));
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
