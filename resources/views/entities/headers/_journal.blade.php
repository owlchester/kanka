<?php /**
 * @var \App\Models\Journal $model
 */
?>
@if ($model->journal || $model->date)
    <div class="entity-header-sub pull-left">
        @if($model->journal)
        <span title="{{ __('crud.fields.parent') }}" data-toggle="tooltip" class="mr-2">
            <x-icon class="ra ra-quill-ink"></x-icon>
            {!! $model->journal->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
                <x-icon class="fa-solid fa-calendar-day"></x-icon>
                {{ $model->date }}
            </span>
        @endif
    </div>
@endif
