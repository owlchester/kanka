<?php /** @var \App\Models\Quest $model */

?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')


<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ trans('quests.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->date)
                    <p class="entity-date">
                        <b>{{ trans('quests.fields.date') }}</b><br />
                        {{ $dateRenderer->render($model->date) }}
                    </p>
                @endif
                @if ($model->quest)
                    <p class="entity-quest" data-foreign="{{ $model->quest_id }}">
                        <b>{{ trans('quests.fields.quest') }}</b><br />
                        {!! $model->quest->tooltipedLink() !!}
                    </p>
                @endif
                @if ($campaign->enabled('characters') && !empty($model->character))
                    <p class="entity-character" data-foreign="{{ $model->character_id }}">
                        <b>{{ trans('quests.fields.character') }}</b><br />
                    {!! $model->character->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->is_completed)
                    <p class="entity-completed">
                        <b>{{ trans('quests.fields.is_completed') }}</b><br />
                        {{ trans('voyager.generic.yes') }}
                    </p>
                @endif

                @include('entities.components.calendar')
            </div>
        </div>
    </div>
</div>
