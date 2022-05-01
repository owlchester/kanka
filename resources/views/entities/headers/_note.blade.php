<?php /**
 * @var \App\Models\Note $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->note)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('notes.fields.note') }}" data-toggle="tooltip">
        <i class="fa-solid fa-book-open"></i>
        {!! $model->note->tooltipedLink() !!}
        </span>
    </div>
@endif
