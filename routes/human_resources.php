<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HumanResourcesController;

Route::prefix('human_resources')->group(function () {
    Route::get('/', [HumanResourcesController::class, 'index'])->name('human_resources.index');
    Route::get('/create', [HumanResourcesController::class, 'create'])->name('human_resources.create');
    Route::post('/store', [HumanResourcesController::class, 'store'])->name('human_resources.store');
    Route::get('/{task}', [HumanResourcesController::class, 'show'])->name('human_resources.show');
    Route::get('/{task}/edit', [HumanResourcesController::class, 'edit'])->name('human_resources.edit');
    Route::put('/{task}', [HumanResourcesController::class, 'update'])->name('human_resources.update');
    Route::delete('/{task}', [HumanResourcesController::class, 'destroy'])->name('human_resources.destroy');
    Route::get('/send-vacancies', [HumanResourcesController::class, 'sendVacanciesToMarketing'])->name('human_resources.send_vacancies');
    Route::get('/review-applications', [HumanResourcesController::class, 'reviewApplications'])->name('human_resources.review_applications');
});

// Additional routes for communication between HR and other departments can be added here