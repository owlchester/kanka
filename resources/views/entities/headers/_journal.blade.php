<?php /**
 * @var \App\Models\Journal $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'journal'])
@if($model->date)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
            <x-icon class="fa-solid fa-calendar-day"></x-icon>
            {{ $model->date }}
        </span>
    </div>
@endif
