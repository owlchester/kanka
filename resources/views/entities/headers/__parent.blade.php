@if ($entity->child->parent)
    <div class="entity-header-sub-element">
        <span class="" data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon :class="\App\Facades\Module::duoIcon($module)" />
        </span>
        <x-entity-link
            :entity="$entity->child->parent->entity"
            :campaign="$campaign" />
    </div>
@endif
