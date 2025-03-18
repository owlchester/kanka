<?php
Route::get('/w/{campaign}/bulk/{entity_type}/batch', [App\Http\Controllers\Bulks\BatchController::class, 'index'])->name('bulk.batch');
Route::post('/w/{campaign}/bulk/{entity_type}/batch', [App\Http\Controllers\Bulks\BatchController::class, 'apply'])->name('bulk.batch.apply');


Route::get('/w/{campaign}/bulk/{entity_type}/templates', [App\Http\Controllers\Bulks\TemplateController::class, 'index'])->name('bulk.templates');
Route::post('/w/{campaign}/bulk/{entity_type}/templates', [App\Http\Controllers\Bulks\TemplateController::class, 'apply'])->name('bulk.templates.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/transform', [App\Http\Controllers\Bulks\TransformController::class, 'index'])->name('bulk.transform');
Route::post('/w/{campaign}/bulk/{entity_type}/transform', [App\Http\Controllers\Bulks\TransformController::class, 'apply'])->name('bulk.transform.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/permissions', [App\Http\Controllers\Bulks\PermissionController::class, 'index'])->name('bulk.permissions');
Route::post('/w/{campaign}/bulk/{entity_type}/permissions', [App\Http\Controllers\Bulks\PermissionController::class, 'apply'])->name('bulk.permissions.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/copy-to-campaign', [App\Http\Controllers\Bulks\CopyController::class, 'index'])->name('bulk.copy-to-campaign');
Route::post('/w/{campaign}/bulk/{entity_type}/copy-to-campaign', [App\Http\Controllers\Bulks\CopyController::class, 'apply'])->name('bulk.copy-to-campaign.apply');

Route::get('/w/{campaign}/bulk/{entity_type}/delete', [App\Http\Controllers\Bulks\DeleteController::class, 'index'])->name('bulk.delete');
Route::post('/w/{campaign}/bulk/{entity_type}/delete', [App\Http\Controllers\Bulks\DeleteController::class, 'apply'])->name('bulk.delete.apply');

Route::get('/w/{campaign}/bulk/relations-delete', [App\Http\Controllers\Bulks\DeleteRelationController::class, 'index'])->name('bulk.delete-relations');
Route::post('/w/{campaign}/bulk/relations-delete', [App\Http\Controllers\Bulks\DeleteRelationController::class, 'apply'])->name('bulk.delete-relations.apply');

Route::post('/w/{campaign}/bulk/{entity_type}/print', [App\Http\Controllers\Bulks\PrintController::class, 'index'])->name('bulk.print');
