<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\GalleryItemController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\BudgetChangeController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\PasswordResetController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('panel');
    });

    Route::get('/panel', [PanelController::class, 'index'])->name('panel');

    Route::middleware('role:administrador')->group(function () {
        Route::resource('clients', ClientController::class);
        Route::resource('budgets', BudgetController::class);
        Route::resource('materials', MaterialController::class);
        Route::resource('workers', WorkerController::class)->except(['show']);

        Route::post('budgets/{budget}/changes', [BudgetChangeController::class, 'store'])
            ->name('budget-changes.store');

        Route::delete('budget-changes/{budgetChange}', [BudgetChangeController::class, 'destroy'])
            ->name('budget-changes.destroy');

        Route::get('budgets/{budget}/pdf/base', [BudgetController::class, 'pdfBase'])
            ->name('budgets.pdf.base');

        Route::get('budgets/{budget}/pdf/final', [BudgetController::class, 'pdfFinal'])
            ->name('budgets.pdf.final');

        Route::post('budgets/{budget}/pdf/send', [BudgetController::class, 'sendPdf'])
            ->name('budgets.pdf.send');
    });

    Route::middleware('role:administrador,trabajador')->group(function () {
        Route::resource('jobs', JobController::class);
        Route::resource('phases', PhaseController::class);
        Route::resource('gallery', GalleryItemController::class);
        Route::resource('incidents', IncidentController::class);

        Route::get('jobs/{job}/phases-json', [JobController::class, 'phasesJson'])
            ->name('jobs.phases.json');
    });
});