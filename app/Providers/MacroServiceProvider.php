<?php
/**
 * This class contains the custom macros that we can use in blade views.
 */
namespace App\Providers;

use App\Facades\EntityPermission;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\Macros;
use Form;
use Collective\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\Blade;

/**
 * Class MacroServiceProvider
 * @package App\Providers
 */
class MacroServiceProvider extends HtmlServiceProvider
{
    /**
     * Define our macros
     */
    public function boot()
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

        Form::component('entityType', 'components.form.entity_types', [
            'fieldId',
            'options' => []
        ]);

        // Not used yet.
        Form::component('private', 'components.form.private', [
            'fieldId',
        ]);

        $this->blade();

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

    protected function blade()
    {
        Blade::if('renderOnce', function ($key) {
            $key = 'render-once-key-' . $key;
            return defined($key)? false : define($key, true);
        });

        /*Blade::directive('tooltip', function (Entity $entity) {
            return "<?php echo '<a class=\"name\" data-toggle=\"tooltip-ajax\" data-id=\"" . $entity->id
                . '" data-url="' . route('entities.tooltip', $entity->id)
                . '" data-html="true" href="' . $entity->url() . '">'
                . e($entity->name)
                . "</a>\"; ?>";
        });*/

//        Blade::if('campaigns', function () {
//            return auth()->check() && auth()->user()->hasCampaigns();
//        });
    }
}
