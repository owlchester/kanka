<?php /**
 * @var \App\Models\DiceRoll $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->character)
    <div class="entity-header-sub pull-left">
        @if($model->character)
        <span title="{{ __('crud.fields.character') }}" data-toggle="tooltip">
        <i class="fa fa-user"></i>
        {!! $model->character->tooltipedLink() !!}
        </span>
        @endif
    </div>
@endif
