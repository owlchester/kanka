<?php /** @var \App\Models\Journal $model */

?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')


<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ trans('journals.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->date)
                    <p>
                        <b>{{ trans('journals.fields.date') }}</b><br />
                        {{ $dateRenderer->render($model->date) }}
                    </p>
                @endif
                @if ($model->journal)
                    <p>
                        <b>{{ trans('journals.fields.journal') }}</b><br />
                        {!! $model->journal->tooltipedLink() !!}
                    </p>
                @endif
                @if ($campaign->enabled('characters') && !empty($model->character))
                    <p>
                        <b>{{ trans('journals.fields.author') }}</b><br />
                    {!! $model->character->tooltipedLink() !!}
                    </p>
                @endif


                @include('entities.components.calendar')
            </div>
        </div>
    </div>
</div>
