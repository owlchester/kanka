<?php /**
 * @var \App\Models\Event $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->date || $model->event)
    <div class="entity-header-sub pull-left">
        @if($model->event)
        <span title="{{ __('events.fields.event') }}" data-toggle="tooltip" class="margin-r-5">
        <i class="fa fa-bolt"></i>
        {!! $model->event->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span title="{{ __('events.fields.date') }}" data-toggle="tooltip">
                <i class="fa fa-calendar-day"></i> {{ $model->date }}
            </span>
        @endif
    </div>
@endif
