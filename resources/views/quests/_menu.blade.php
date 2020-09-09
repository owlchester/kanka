<?php /** @var \App\Models\Quest $model */?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')

<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')
        @endif

        <ul class="list-group list-group-unbordered">
            @if ($model->type)
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->date)
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.date') }}</b> <span class="pull-right">{{ $dateRenderer->render($model->date) }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->quest)
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.quest') }}</b>
                    <span class="pull-right">
                        {!! $model->quest->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($campaign->enabled('characters') && !empty($model->character))
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.character') }}</b>
                    <span  class="pull-right">
                        {!! $model->character->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->is_completed)
                <li class="list-group-item">
                    <b>{{ trans('quests.fields.is_completed') }}</b>
                    <span class="pull-right">{{ trans('voyager.generic.yes') }}</span>
                </li>
            @endif

            @include('entities.components.calendar')
            @include('entities.components.relations')
            @include('entities.components.attributes')
                @include('entities.components.tags')
        </ul>
    </div>
</div>

@include('entities.components.menu')
@include('entities.components.actions', ['disableMove' => true])
