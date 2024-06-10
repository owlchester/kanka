<?php /**
 * @var \App\Models\Journal $model
 */
?>
@if ($model->journal || $model->date)
    <div class="entity-header-sub entity-header-line">
    @if($model->journal)
        <div class="entity-header-sub-element">
            <x-icon :class="\App\Facades\Module::duoIcon('journal')" :title="__('crud.fields.parent')" />
            <x-entity-link
                :entity="$model->journal->entity"
                :campaign="$campaign" />
        </div>
    @endif

    @if($model->date)
        <div class="entity-header-sub-element">
            <span data-title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
                <x-icon class="fa-solid fa-calendar-day"></x-icon>
                {{ $model->date }}
            </span>
        </div>
    @endif
    </div>
@endif
