<?php

use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;
use App\Http\Controllers\OrdenTrabajoController;

Route::redirect('/', '/api/documentation');

Route::get('/api/documentation', [SwaggerController::class, 'api']);

Route::get('/debug-paths', function () {
    return [
        'base_path' => base_path(),
        'storage_path' => storage_path(),
        'view_compiled_path' => config('view.compiled'),
    ];
});

/*
 Route::get('/', function () {
    return view('welcome');
});

Route::get('/orden-de-trabajo/aprobar/{id}', [OrdenTrabajoController::class, 'verAprobacion'])->name('ordenTrabajo.aprobar.view');
Route::post('/orden-de-trabajo/{id}/aprobar', [OrdenTrabajoController::class, 'aprobar'])->name('ordenTrabajo.aprobar');
*/