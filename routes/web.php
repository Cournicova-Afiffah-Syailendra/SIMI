<?php

use App\Http\Controllers\User\UserLoanController;
use App\Http\Controllers\User\AjukanController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\KatalogController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanRequestController;
use App\Models\Inventory;
use App\Models\LoanRequest;
use App\Http\Controllers\AjukanPublikController;

Route::get('/', function () {
   return view('landingpage');
})->name('landing');
// ── Route Publik (tanpa login) ──────────────────────────
Route::get('/ajukan', [AjukanPublikController::class, 'index'])
     ->name('publik.ajukan');
Route::post('/ajukan', [AjukanPublikController::class, 'store'])
     ->name('publik.ajukan.store');

// ── Dashboard Admin ──────────────────────────────────────
Route::get('/dashboard', function () {
    $totalInventories = Inventory::count();
    $activeLoans = LoanRequest::where('status', 'approved')->count();
    $pendingLoans = LoanRequest::where('status', 'pending')->count();
    $latestLoanRequests = LoanRequest::with('inventory')->latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'totalInventories',
        'activeLoans',
        'pendingLoans',
        'latestLoanRequests'
    ));
})->middleware('auth')->name('dashboard');

// ── User Routes ──────────────────────────────────────────
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/ajukan', [AjukanController::class, 'index'])->name('ajukan');
    Route::post('/ajukan', [AjukanController::class, 'store'])->name('ajukan.store');
});

// ── Admin Routes ─────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::post('/returns/{loanRequest}/confirm', [ReturnController::class, 'confirm'])->name('returns.confirm');

    Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
    Route::post('/inventories', [InventoryController::class, 'store'])->name('inventories.store');
    Route::put('/inventories/{inventory}', [InventoryController::class, 'update'])->name('inventories.update');
    Route::delete('/inventories/{inventory}', [InventoryController::class, 'destroy'])->name('inventories.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/loan-requests', [LoanRequestController::class, 'index'])->name('loan-requests.index');
    Route::post('/loan-requests', [LoanRequestController::class, 'store'])->name('loan-requests.store');
    Route::patch('/loan-requests/{loanRequest}/approve', [LoanRequestController::class, 'approve'])->name('loan-requests.approve');
    Route::patch('/loan-requests/{loanRequest}/reject', [LoanRequestController::class, 'reject'])->name('loan-requests.reject');

});

require __DIR__ . '/auth.php';
