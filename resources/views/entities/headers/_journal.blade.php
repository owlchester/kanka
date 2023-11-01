<?php /**
 * @var \App\Models\Journal $model
 */
?>
@if ($model->journal || $model->date)
    <div class="entity-header-sub pull-left flex items-center gap-2">
        @if($model->journal)
        <span>
            <x-icon entity="journal" :title="__('crud.fields.parent')"/>
            {!! $model->journal->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span data-title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
                <x-icon class="fa-solid fa-calendar-day"></x-icon>
                {{ $model->date }}
            </span>
        @endif
    </div>
@endif
