<?php
/**
 * This class contains the custom macros that we can use in blade views.
 */
namespace App\Providers;

use App\Models\MiscModel;
use App\Services\Macros;
use Form;
use Collective\Html\HtmlServiceProvider;

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
        ]);

        Form::component('tags', 'components.form.tags', [
            'fieldId',
            'options' => []
        ]);

        Form::component('members', 'components.form.members', [
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
}
