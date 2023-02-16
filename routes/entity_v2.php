<?php



//Ability reorder
Route::get('/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\AbilityReorderController::class, 'index'])->name('entities.entity_abilities.reorder');
Route::post('/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\AbilityReorderController::class, 'save'])->name('entities.entity_abilities.reorder-save');

// Attribute multi-save
Route::get('/entities/{entity}/attributes', [\App\Http\Controllers\Entity\AttributeController::class, 'index'])->name('entities.attributes');
Route::get('/entities/{entity}/attributes/edit', [\App\Http\Controllers\Entity\AttributeController::class, 'edit'])->name('entities.attributes.edit');
Route::post('/entities/{entity}/attributes/save', [\App\Http\Controllers\Entity\AttributeController::class, 'save'])->name('entities.attributes.save');
Route::get('/entities/{entity}/attributes/live-edit/', [\App\Http\Controllers\Entity\AttributeController::class, 'liveEdit'])->name('entities.attributes.live.edit');
Route::post('/entities/{entity}/attributes/live-edit/{attribute}/save', [\App\Http\Controllers\Entity\AttributeController::class, 'liveSave'])->name('entities.attributes.live.save');


Route::get('/entities/{entity}/story-reorder', [\App\Http\Controllers\Entity\StoryController::class, 'edit'])->name('entities.story.reorder');
Route::post('/entities/{entity}/story-reorder', [\App\Http\Controllers\Entity\StoryController::class, 'save'])->name('entities.story.reorder-save');
Route::get('/entities/{entity}/story-more', [\App\Http\Controllers\Entity\StoryController::class, 'more'])->name('entities.story.load-more');

// Image of entities
Route::get('/entities/{entity}/image-focus', [\App\Http\Controllers\Entity\ImageController::class, 'focus'])->name('entities.image.focus');
Route::post('/entities/{entity}/image-focus', [\App\Http\Controllers\Entity\ImageController::class, 'saveFocus'])->name('entities.image.save-focus');

Route::get('/entities/{entity}/image-replace', [\App\Http\Controllers\Entity\ImageController::class, 'replace'])->name('entities.image.replace');
Route::post('/entities/{entity}/image-replace', [\App\Http\Controllers\Entity\ImageController::class, 'update'])->name('entities.image.replace.save');

// Quick privacy toggle
Route::get('/entities/{entity}/privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'index'])->name('entities.quick-privacy');
Route::post('/entities/{entity}/privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.quick-privacy.toggle');
//Route::post('/entities/{entity}/toggle-privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.privacy.toggle');


// Entity update entry
Route::get('/entities/{entity}/entry', [\App\Http\Controllers\Entity\EntryController::class, 'edit'])->name('entities.entry.edit');
Route::patch('/entities/{entity}/entry', [\App\Http\Controllers\Entity\EntryController::class, 'update'])->name('entities.entry.update');

Route::get('/entities/{entity}/relations_map', [\App\Http\Controllers\Entity\RelationController::class, 'map'])->name('entities.relations_map');
Route::get('/entities/{entity}/relations/table', [\App\Http\Controllers\Entity\RelationController::class, 'table'])->name('entities.relations_table');


// Entity Abilities API
Route::get('/entities/{entity}/abilities', [\App\Http\Controllers\Entity\AbilityController::class, 'index'])->name('entities.abilities');
Route::get('/entities/{entity}/entity_abilities/api', [\App\Http\Controllers\Entity\AbilityController::class, 'api'])->name('entities.entity_abilities.api');
Route::get('/entities/{entity}/entity_abilities/import', [\App\Http\Controllers\Entity\AbilityController::class, 'import'])->name('entities.entity_abilities.import');
Route::post('/entities/{entity}/entity_abilities/{entity_ability}/use', [\App\Http\Controllers\Entity\AbilityController::class, 'useCharge'])->name('entities.entity_abilities.use');
Route::get('/entities/{entity}/entity_abilities/reset', [\App\Http\Controllers\Entity\AbilityController::class, 'resetCharges'])->name('entities.entity_abilities.reset');

Route::get('/entities/{entity}/entity_assets/{entity_asset}/go', [\App\Http\Controllers\Entity\AssetController::class, 'go'])->name('entities.entity_assets.go');


Route::get('/entities/{entity}/quests', [\App\Http\Controllers\Entity\QuestController::class, 'index'])->name('entities.quests');
Route::get('/entities/{entity}/profile', [\App\Http\Controllers\Entity\ProfileController::class, 'index'])->name('entities.profile');

// Move
Route::get('/entities/{entity}/move', [\App\Http\Controllers\Entity\MoveController::class, 'index'])->name('entities.move');
Route::post('/entities/{entity}/move', [\App\Http\Controllers\Entity\MoveController::class, 'move'])->name('entities.move');

Route::get('/entities/{entity}/posts/{post}/move', [\App\Http\Controllers\Entity\PostMoveController::class, 'index'])->name('posts.move');
Route::post('/entities/{entity}/posts/{post}/move', [\App\Http\Controllers\Entity\PostMoveController::class, 'move'])->name('posts.move');

// Transform
Route::get('/entities/{entity}/transform', [\App\Http\Controllers\Entity\TransformController::class, 'index'])->name('entities.transform');
Route::post('/entities/{entity}/transform', [\App\Http\Controllers\Entity\TransformController::class, 'transform'])->name('entities.transform');

Route::get('/entities/{entity}/tooltip', [\App\Http\Controllers\Entity\TooltipController::class, 'show'])->name('entities.tooltip');

Route::get('/entities/{entity}/json-export', [\App\Http\Controllers\Entity\ExportController::class, 'json'])->name('entities.json-export');
Route::get('/entities/{entity}/html-export', [\App\Http\Controllers\Entity\ExportController::class, 'html'])->name('entities.html-export');


// Entity files
Route::get('/entities/{entity}/logs', [\App\Http\Controllers\Entity\LogController::class, 'index'])->name('entities.logs');
Route::get('/entities/{entity}/mentions', [\App\Http\Controllers\Entity\MentionController::class, 'index'])->name('entities.mentions');


// Inventory
Route::get('/entities/{entity}/inventory', [\App\Http\Controllers\Entity\InventoryController::class, 'index'])->name('entities.inventory');

// Export
Route::get('/entities/export/{entity}', 'EntityController@export')->name('entities.export');


Route::get('/entities/{entity}/template', 'EntityController@template')->name('entities.template');

// Attribute template
Route::get('/entities/{entity}/attribute-template', [\App\Http\Controllers\Entity\AttributeTemplateController::class, 'apply'])->name('entities.attributes.template');
Route::post('/entities/{entity}/attribute-template', [\App\Http\Controllers\Entity\AttributeTemplateController::class, 'applyTemplate'])->name('entities.attributes.template');

Route::get('/entities/{entity}/permissions', 'PermissionController@view')->name('entities.permissions');
Route::post('/entities/{entity}/permissions', 'PermissionController@store')->name('entities.permissions');


Route::resources([
    'entities.entity_abilities' => 'Entity\AbilityController',
    'entities.entity_notes' => 'EntityNoteController',
    'entities.posts' => 'Entity\PostController',
    'entities.entity_events' => 'EntityEventController',
    'entities.entity_assets' => 'Entity\AssetController',
    'entities.inventories' => 'Entity\InventoryController',
    'entities.relations' => 'Entity\RelationController',
]);
