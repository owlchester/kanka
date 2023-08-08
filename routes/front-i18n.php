<?php

use App\Http\Controllers\CommunityVoteController;
use App\Http\Controllers\Front\CommunityEventController;
use App\Http\Controllers\Front\CommunityEventEntryController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\FeatureController;
use App\Http\Controllers\Front\HallOfFameController;
use App\Http\Controllers\Front\HelperController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/front', [FrontController::class, 'index'])->name('front.home');
Route::get('/about', [FrontController::class, 'about'])->name('front.about');
Route::get('/goodbye', [FrontController::class, 'goodbye'])->name('front.goodbye');
Route::get('/privacy-policy', [FrontController::class, 'privacy'])->name('front.privacy');
Route::get('/terms-and-conditions', [FrontController::class, 'terms'])->name('front.terms');
Route::get('/features', [FrontController::class, 'features'])->name('front.features');
Route::get('/gm-features', [FrontController::class, 'gmFeatures'])->name('front.gm-features');
Route::get('/worldbuilding-features', [FrontController::class, 'wbFeatures'])->name('front.worldbuilder-features');
Route::get('/roadmap', [FrontController::class, 'roadmap'])->name('front.roadmap');
Route::get('/public-campaigns', [FrontController::class, 'campaigns'])->name('front.public_campaigns');
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');
Route::get('/partners', [FrontController::class, 'partners'])->name('front.partners');
Route::get('/newsletter', [NewsletterController::class, 'index'])->name('front.newsletter');

Route::get('/boosters', [\App\Http\Controllers\FrontController::class, 'boosters'])->name('front.boosters');
Route::get('/press-kit', [\App\Http\Controllers\FrontController::class, 'pressKit'])->name('front.press-kit');
Route::get('/security', [\App\Http\Controllers\FrontController::class, 'security'])->name('front.security');
Route::get('/premium', [\App\Http\Controllers\FrontController::class, 'premium'])->name('front.premium');

Route::get('/kb', [FaqController::class, 'index'])->name('front.faqs.index');
Route::get('/kb/{faq}-{slug?}', [FaqController::class, 'show'])->name('front.faqs.show');

Route::get('/features/calendars', [FeatureController::class, 'calendars'])->name('front.features.calendars');
Route::get('/features/timelines', [FeatureController::class, 'timelines'])->name('front.features.timelines');
Route::get('/features/secrets', [FeatureController::class, 'secrets'])->name('front.features.secrets');
Route::get('/features/maps', [FeatureController::class, 'maps'])->name('front.features.maps');
Route::get('/features/permissions', [FeatureController::class, 'permissions'])->name('front.features.permissions');
Route::get('/features/boosters', [FeatureController::class, 'boosters'])->name('front.features.boosters');
Route::get('/features/inventories-abilities', [FeatureController::class, 'inventoriesAbilities'])->name('front.features.inventories-abilities');
Route::get('/features/dashboards', [FeatureController::class, 'dashboards'])->name('front.features.dashboards');
Route::get('/features/relations', [FeatureController::class, 'relations'])->name('front.features.relations');
//Route::get('/features/rich-text', [FeatureController::class, 'richText'])->name('front.features.rich-text');

Route::get('/hall-of-fame', [HallOfFameController::class, 'index'])->name('front.hall-of-fame');

Route::post('/community-votes/{community_vote}/vote', [CommunityVoteController::class, 'vote'])->name('community-votes.vote');
Route::resources([
    'community-votes' => CommunityVoteController::class,
    'community-events' => CommunityEventController::class,
    'community-events.community-event-entries' => CommunityEventEntryController::class,
]);

Route::group(['prefix' => 'helper'], function () {
    Route::get('/api-filters', [HelperController::class, 'apiFilters'])
        ->name('helpers.api-filters');
});

Route::get('users/{user}', [ProfileController::class, 'show'])->name('users.profile');
