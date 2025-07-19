<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenTrabajoController;

Route::redirect('/', '/api/documentation');

/*
 Route::get('/', function () {
    return view('welcome');
});

Route::get('/orden-de-trabajo/aprobar/{id}', [OrdenTrabajoController::class, 'verAprobacion'])->name('ordenTrabajo.aprobar.view');
Route::post('/orden-de-trabajo/{id}/aprobar', [OrdenTrabajoController::class, 'aprobar'])->name('ordenTrabajo.aprobar');
*/