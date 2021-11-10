<?php /**
 * @var \App\Models\Journal $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->journal || $model->date)
    <div class="entity-header-sub pull-left">
        @if($model->journal)
        <span title="{{ __('journals.fields.journal') }}" data-toggle="tooltip" class="margin-r-5">
        <i class="ra ra-quill-ink"></i>
        {!! $model->journal->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
                <i class="fa fa-calendar-day"></i> {{ $model->date }}
            </span>
        @endif
    </div>
@endif
