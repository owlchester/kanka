<?php

use \App\Http\Controllers\Maps\MapController;
use \App\Http\Controllers\Maps\MapGroupController;
use \App\Http\Controllers\Maps\MapLayerController;
use \App\Http\Controllers\Maps\MapMarkerController;

Route::get('/quick-links/{menu_link}/random', [\App\Http\Controllers\MenuLinkController::class, 'random'])->name('quick-links.random');
Route::get('/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'reorder'])->name('quick-links.reorder');
Route::post('/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'save'])->name('quick-links.reorder-save');

Route::get('/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'index'])->name('timelines.reorder');
Route::post('/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'save'])->name('timelines.reorder-save');

Route::post('/timelines/{timeline}/eras/bulk', [\App\Http\Controllers\Timelines\TimelineEraController::class, 'bulk'])->name('timelines.eras.bulk');


// Tags Quick Add
Route::get('/tags/{tag}/entity-add', [\App\Http\Controllers\TagController::class, 'entityAdd'])->name('tags.entity-add');
Route::post('/tags/{tag}/entity-add', [\App\Http\Controllers\TagController::class, 'entityStore'])->name('tags.entity-add.save');

Route::get('/abilities/{ability}/entity-add', [\App\Http\Controllers\AbilityController::class, 'entityAdd'])->name('abilities.entity-add');
Route::post('/abilities/{ability}/entity-add', [\App\Http\Controllers\AbilityController::class, 'entityStore'])->name('abilities.entity-add.save');

// Maps
Route::get('/maps/{map}/maps', [MapController::class, 'maps'])->name('maps.maps');
Route::get('/maps/{map}/explore', [MapController::class, 'explore'])->name('maps.explore');
Route::get('/maps/{map}/chunks/', [MapController::class, 'chunks'])->name('maps.chunks');
Route::get('/maps/{map}/ticker', [MapController::class, 'ticket'])->name('maps.ticker');

Route::post('/maps/{map}/groups/bulk', [MapGroupController::class, 'bulk'])->name('maps.groups.bulk');
Route::post('/maps/{map}/groups/reorder', [MapGroupController::class, 'reorder'])->name('maps.groups.reorder-save');

Route::post('/maps/{map}/layers/bulk', [MapLayerController::class, 'bulk'])->name('maps.layers.bulk');
Route::post('/maps/{map}/layers/reorder', [MapLayerController::class, 'reorder'])->name('maps.layers.reorder-save');

Route::post('/maps/{map}/markers/bulk', [MapMarkerController::class, 'bulk'])->name('maps.markers.bulk');
