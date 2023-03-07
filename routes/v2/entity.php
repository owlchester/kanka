<?php

use App\Http\Controllers\Entity\AbilityController;
use App\Http\Controllers\Entity\AbilityReorderController;
use App\Http\Controllers\Entity\AttributeController;
use App\Http\Controllers\Entity\AttributeTemplateController;
use App\Http\Controllers\Entity\AssetController;
use App\Http\Controllers\Entity\DescendantController;
use App\Http\Controllers\Entity\EntryController;
use App\Http\Controllers\Entity\ExportController;
use App\Http\Controllers\Entity\ImageController;
use App\Http\Controllers\Entity\InventoryController;
use App\Http\Controllers\Entity\LogController;
use App\Http\Controllers\Entity\MentionController;
use App\Http\Controllers\Entity\MoveController;
use App\Http\Controllers\Entity\PermissionController;
use App\Http\Controllers\Entity\PostMoveController;
use App\Http\Controllers\Entity\PrivacyController;
use App\Http\Controllers\Entity\ProfileController;
use App\Http\Controllers\Entity\RelationController;
use App\Http\Controllers\Entity\TemplateController;
use App\Http\Controllers\Entity\TooltipController;
use App\Http\Controllers\Entity\TransformController;
use App\Http\Controllers\Entity\StoryController;

//Ability reorder
Route::get('/entity/{entity}/abilities/reorder', [AbilityReorderController::class, 'index'])->name('entities.entity_abilities.reorder');
Route::post('/entity/{entity}/abilities/reorder', [AbilityReorderController::class, 'save'])->name('entities.entity_abilities.reorder-save');

// Attribute multi-save
Route::get('/entities/{entity}/attributes', [AttributeController::class, 'index'])->name('entities.attributes');
Route::get('/entities/{entity}/attributes/edit', [AttributeController::class, 'edit'])->name('entities.attributes.edit');
Route::post('/entities/{entity}/attributes/save', [AttributeController::class, 'save'])->name('entities.attributes.save');
Route::get('/entities/{entity}/attributes/live-edit/', [AttributeController::class, 'liveEdit'])->name('entities.attributes.live.edit');
Route::post('/entities/{entity}/attributes/live-edit/{attribute}/save', [AttributeController::class, 'liveSave'])->name('entities.attributes.live.save');


Route::get('/entities/{entity}/story-reorder', [StoryController::class, 'edit'])->name('entities.story.reorder');
Route::post('/entities/{entity}/story-reorder', [StoryController::class, 'save'])->name('entities.story.reorder-save');
Route::get('/entities/{entity}/story-more', [StoryController::class, 'more'])->name('entities.story.load-more');

// Image of entities
Route::get('/entities/{entity}/image-focus', [ImageController::class, 'focus'])->name('entities.image.focus');
Route::post('/entities/{entity}/image-focus', [ImageController::class, 'saveFocus'])->name('entities.image.save-focus');

Route::get('/entities/{entity}/image-replace', [ImageController::class, 'replace'])->name('entities.image.replace');
Route::post('/entities/{entity}/image-replace', [ImageController::class, 'update'])->name('entities.image.replace.save');

// Quick privacy toggle
Route::get('/entities/{entity}/privacy', [PrivacyController::class, 'index'])->name('entities.quick-privacy');
Route::post('/entities/{entity}/privacy', [PrivacyController::class, 'toggle'])->name('entities.quick-privacy.toggle');


// Entity update entry
Route::get('/entities/{entity}/entry', [EntryController::class, 'edit'])->name('entities.entry.edit');
Route::patch('/entities/{entity}/entry', [EntryController::class, 'update'])->name('entities.entry.update');

Route::get('/entities/{entity}/relations_map', [RelationController::class, 'map'])->name('entities.relations_map');
Route::get('/entities/{entity}/relations/table', [RelationController::class, 'table'])->name('entities.relations_table');


// Entity Abilities API
Route::get('/entities/{entity}/abilities', [AbilityController::class, 'index'])->name('entities.abilities');
Route::get('/entities/{entity}/abilities/api', [AbilityController::class, 'api'])->name('entities.entity_abilities.api');
Route::get('/entities/{entity}/abilities/import', [AbilityController::class, 'import'])->name('entities.entity_abilities.import');
Route::post('/entities/{entity}/abilities/{entity_ability}/use', [AbilityController::class, 'useCharge'])->name('entities.entity_abilities.use');
Route::get('/entities/{entity}/abilities/reset', [AbilityController::class, 'resetCharges'])->name('entities.entity_abilities.reset');

Route::get('/entities/{entity}/entity_assets/{entity_asset}/go', [AssetController::class, 'go'])->name('entities.entity_assets.go');

Route::get('/entities/{entity}/quests', [\App\Http\Controllers\Entity\QuestController::class, 'index'])->name('entities.quests');
Route::get('/entities/{entity}/profile', [ProfileController::class, 'index'])->name('entities.profile');

// Move
Route::get('/entities/{entity}/move', [MoveController::class, 'index'])->name('entities.move');
Route::post('/entities/{entity}/move', [MoveController::class, 'move'])->name('entities.move');

Route::get('/entities/{entity}/posts/{post}/move', [PostMoveController::class, 'index'])->name('posts.move');
Route::post('/entities/{entity}/posts/{post}/move', [PostMoveController::class, 'move'])->name('posts.move');

// Transform
Route::get('/entities/{entity}/transform', [TransformController::class, 'index'])->name('entities.transform');
Route::post('/entities/{entity}/transform', [TransformController::class, 'transform'])->name('entities.transform');

Route::get('/entities/{entity}/tooltip', [TooltipController::class, 'show'])->name('entities.tooltip');

Route::get('/entities/{entity}/json-export', [ExportController::class, 'json'])->name('entities.json-export');
Route::get('/entities/{entity}/html-export', [ExportController::class, 'html'])->name('entities.html-export');


Route::get('/entities/{entity}/logs', [LogController::class, 'index'])->name('entities.logs');
Route::get('/entities/{entity}/mentions', [MentionController::class, 'index'])->name('entities.mentions');


// Inventory
Route::get('/entities/{entity}/inventory', [InventoryController::class, 'index'])->name('entities.inventory');

// Export
//Route::get('/entities/export/{entity}', 'EntityController@export')->name('entities.export');

Route::get('/entities/{entity}/template', [TemplateController::class, 'update'])->name('entities.template');

// Attribute template
Route::get('/entities/{entity}/attribute-template', [AttributeTemplateController::class, 'apply'])->name('entities.attributes.template');
Route::post('/entities/{entity}/attribute-template', [AttributeTemplateController::class, 'applyTemplate'])->name('entities.attributes.template');

Route::get('/entities/{entity}/permissions', [PermissionController::class, 'view'])->name('entities.permissions');
Route::post('/entities/{entity}/permissions', [PermissionController::class, 'store'])->name('entities.permissions');

Route::get('/entities/{entity}/preview', 'Entity\PreviewController@index')->name('entities.preview');

Route::get('/entities/{entity}/descendants', [DescendantController::class, 'index'])->name('entities.descendants');

Route::resources([
    'entities.entity_abilities' => 'Entity\AbilityController',
    'entities.entity_notes' => 'EntityNoteController',
    'entities.posts' => 'Entity\PostController',
    'entities.entity_events' => 'Entity\ReminderController',
    'entities.entity_assets' => 'Entity\AssetController',
    'entities.inventories' => 'Entity\InventoryController',
    'entities.relations' => 'Entity\RelationController',
]);
