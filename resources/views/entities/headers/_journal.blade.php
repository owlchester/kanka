<?php /**
 * @var \App\Models\Journal $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->date || $model->character)
    <div class="entity-header-sub pull-left">
        @if($model->character)
        <span title="{{ __('journals.fields.author') }}" data-toggle="tooltip" class="margin-r-5">
        <i class="fa fa-user"></i>
        {!! $model->character->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
                <i class="fa fa-calendar-day"></i> {{ $model->date }}
            </span>
        @endif
    </div>
@endif
