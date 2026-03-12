<?php

use App\Http\Controllers\Bulks\BatchController;
use App\Http\Controllers\Bulks\CopyController;
use App\Http\Controllers\Bulks\DeleteController;
use App\Http\Controllers\Bulks\DeleteRelationController;
use App\Http\Controllers\Bulks\PermissionController;
use App\Http\Controllers\Bulks\PrintController;
use App\Http\Controllers\Bulks\TemplateController;
use App\Http\Controllers\Bulks\TransformController;

Route::get('/w/{campaign}/bulk/{entity_type}/batch', [BatchController::class, 'index'])->name('bulk.batch');
Route::post('/w/{campaign}/bulk/{entity_type}/batch', [BatchController::class, 'apply'])->name('bulk.batch.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/templates', [TemplateController::class, 'index'])->name('bulk.templates');
Route::post('/w/{campaign}/bulk/{entity_type}/templates', [TemplateController::class, 'apply'])->name('bulk.templates.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/transform', [TransformController::class, 'index'])->name('bulk.transform');
Route::post('/w/{campaign}/bulk/{entity_type}/transform', [TransformController::class, 'apply'])->name('bulk.transform.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/permissions', [PermissionController::class, 'index'])->name('bulk.permissions');
Route::post('/w/{campaign}/bulk/{entity_type}/permissions', [PermissionController::class, 'apply'])->name('bulk.permissions.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/copy-to-campaign', [CopyController::class, 'index'])->name('bulk.copy-to-campaign');
Route::post('/w/{campaign}/bulk/{entity_type}/copy-to-campaign', [CopyController::class, 'apply'])->name('bulk.copy-to-campaign.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/delete', [DeleteController::class, 'index'])->name('bulk.delete');
Route::post('/w/{campaign}/bulk/{entity_type}/delete', [DeleteController::class, 'apply'])->name('bulk.delete.apply');

Route::get('/w/{campaign}/bulk/relations-delete', [DeleteRelationController::class, 'index'])->name('bulk.delete-relations');
Route::post('/w/{campaign}/bulk/relations-delete', [DeleteRelationController::class, 'apply'])->name('bulk.delete-relations.apply');

Route::post('/w/{campaign}/bulk/{entity_type}/print', [PrintController::class, 'index'])->name('bulk.print');
