<?php
/**
 * This class contains the custom macros that we can use in blade views.
 */
namespace App\Providers;

use App\Facades\AdCache;
use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Facades\Img;
use App\Models\Entity;
use App\User;
use Carbon\Carbon;
use Form;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class MacroServiceProvider
 * @package App\Providers
 */
class MacroServiceProvider extends ServiceProvider
{
    /**
     * Define our macros
     */
    public function boot()
    {
        $this->addFormDirectives();
        $this->addCustomBladeDirectives();
    }

    /**
     *
     */
    protected function addFormDirectives()
    {
        Form::component('select2', 'components.form.select2', [
            'fieldId',
            'prefill' => null,
            'prefillModel' => null,
            'allowNew' => false,
            'labelKey' => null,
            'searchRouteName' => null,
            'placeholderKey' => null,
            'from' => null,
            'dropdownParent' => null,
        ]);

        Form::component('foreignSelect', 'components.form.select3', [
            'fieldId',
            'options' => []
        ]);

        Form::component('tags', 'components.form.tags', [
            'fieldId',
            'options' => []
        ]);

        Form::component('abilities', 'components.form.abilities', [
            'fieldId',
            'options' => []
        ]);

        Form::component('rpg_systems', 'components.form.rpg_systems', [
            'fieldId',
            'options' => []
        ]);

        Form::component('members', 'components.form.members', [
            'fieldId',
            'options' => []
        ]);
        Form::component('races', 'components.form.races', [
            'fieldId',
            'options' => []
        ]);
        Form::component('families', 'components.form.families', [
            'fieldId',
            'options' => []
        ]);
        Form::component('familyMembers', 'components.form.family_members', [
            'fieldId',
            'options' => []
        ]);
        Form::component('user', 'components.form.user', [
            'fieldId',
            'options' => []
        ]);
        Form::component('role', 'components.form.role', [
            'fieldId',
            'options' => []
        ]);

        Form::component('entityType', 'components.form.entity_types', [
            'fieldId',
            'options' => []
        ]);

        // Not used yet.
        Form::component('private', 'components.form.private', [
            'fieldId',
        ]);

        /*Form::function($fieldId, $searchRouteName, $prefill = null, $placeholderKey = null) {

            $placeholderKey = empty($placeholderKey) ? 'crud.placeholders.' . trim($fieldId) : $placeholderKey;

            $selectedOption = [];
            if (!empty($prefill) && $prefill instanceof MiscModel) {
                $selectedOption = [$prefill->id => $prefill->name];
            } else {
                // Old?
            }

            return Form::select2(
                $fieldId,
                $selectedOption,
                [],
                [
                    'id' => $fieldId,
                    'class' => 'form-control select2',
                    'style' => 'width: 100%',
                    'data-url' => route($searchRouteName),
                    'data-placeholder' => trans($placeholderKey)
                ]
            );
        });*/
    }

    /**
     * Setup some custom blade directives to simply some code
     * For example, use @admin in blade
     */
    protected function addCustomBladeDirectives()
    {
        /*Blade::if('renderOnce', function ($key) {
            $key = 'render-once-key-' . $key;
            return defined($key)? false : define($key, true);
        });*/
        // Permission to view an entity
        Blade::if('viewentity', function (Entity $entity) {
            return EntityPermission::canView($entity);
        });

        // If a webp fallback is needed
        Blade::if('nowebp', function () {
            return Img::nowebp();
        });

        // Tutorial modal handler
        Blade::if('tutorial', function (string $tutorial) {
            // Not logged in? Don't bother
            if (!auth()->check()) {
                return false;
            }

            /** @var User $user */
            $user = auth()->user();

            // If disabled tutorials, remove all
            if ($user->disabledTutorial()) {
                return false;
            }

            return !$user->readTutorial($tutorial);
        });

        /** @ads() to show ads */
        Blade::if('ads', function(string $section = null) {
            if (empty(config('tracking.adsense'))) {
                return false;
            }

            // If requesting a section but it isn't set up, don't show
            if (!empty($section) && empty(config('tracking.adsense_' . $section))) {
                return false;
            }

            // Always show ads to unlogged users
            if (!auth()->check()) {
                return true;
            }

            // Subscribed users don't have ads
            if (auth()->user()->isPatron()) {
                return false;
            }

            // User has been created less than 24 hours ago
            if (auth()->user()->created_at->diffInHours(Carbon::now()) < 24) {
                return false;
            }

            // Boosted campaigns don't either have ads displayed to their members
            $campaign = CampaignLocalization::getCampaign(false);
            return !empty($campaign) && !$campaign->boosted();
        });

        Blade::if('nativeAd', function (int $section) {
            // If we provided an ad test, override that
            if (request()->has('_adtest') && auth()->user()->hasRole('admin')) {
                return AdCache::test($section, request()->get('_adtest'));
            }
            if (!AdCache::has($section)) {
                return false;
            }
            // Always show ads to unlogged users
            if (!auth()->check()) {
                return true;
            }

            if (request()->get('_boost') === '0') {
                return true;
            }

            // Subscribed users don't have ads
            if (auth()->user()->isPatron()) {
                return false;
            }

            // User has been created less than 24 hours ago
            if (auth()->user()->created_at->diffInHours(Carbon::now()) < 24) {
                return false;
            }

            // Boosted campaigns don't either have ads displayed to their members
            $campaign = CampaignLocalization::getCampaign(false);
            return !empty($campaign) && !$campaign->boosted();
        });
    }
}
