<?php /**
 * @var \App\Models\Journal $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->journal || $model->date)
    <div class="entity-header-sub pull-left">
        @if($model->journal)
        <span title="{{ __('crud.fields.parent') }}" data-toggle="tooltip" class="mr-2">
        <i class="ra ra-quill-ink" aria-hidden="true"></i>
        {!! $model->journal->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
                <i class="fa-solid fa-calendar-day" aria-hidden="true"></i> {{ $model->date }}
            </span>
        @endif
    </div>
@endif
