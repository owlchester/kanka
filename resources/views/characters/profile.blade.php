@include('entities.components.elasped_events')
@if ($model->age || $model->age === '0')
    <li class="list-group-item">
        <b>{{ trans('characters.fields.age') }}</b> <span class="pull-right">{{ $model->age }}</span>
        <br class="clear" />
    </li>
@endif
@if ($model->sex)
    <li class="list-group-item">
        <b>{{ trans('characters.fields.sex') }}</b> <span class="pull-right">{{ $model->sex }}</span>
        <br class="clear" />
    </li>
@endif
@if ($model->pronouns)
    <li class="list-group-item">
        <b>{{ trans('characters.fields.pronouns') }}</b> <span class="pull-right">{{ $model->pronouns }}</span>
        <br class="clear" />
    </li>
@endif
@foreach ($model->characterTraits()->appearance()->orderBy('default_order')->get() as $trait)
    <li class="list-group-item">
        <b>{{ $trait->name }}</b> <span class="pull-right">{{ $trait->entry }}</span>
        <br class="clear" />
    </li>
@endforeach

@if (((Auth::check() && Auth::user()->can('personality', $model)) || $model->is_personality_visible) && $model->characterTraits()->personality()->count() > 0)
    <div class="box box-solid">
        <div class="box-header">
            @if(auth()->check() && auth()->user()->can('personality', $model))
                <span class="pull-right">
                @if (!$model->is_personality_visible)
                        <i class="fa fa-lock" title="{{ __('characters.hints.personality_not_visible') }}" data-toggle="tooltip"></i>
                    @else
                        <i class="fa fa-lock-open" title="{{ __('characters.hints.personality_visible') }}" data-toggle="tooltip"></i>
                    @endif
                </span>
            @endif

            <h3 class="box-title">{{ trans('characters.show.tabs.personality') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @foreach ($model->characterTraits()->personality()->orderBy('default_order')->get() as $trait)
                <p><b>{{ $trait->name }}</b><br />{!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}</p>
            @endforeach
        </div>
    </div>
@endif

@if ($campaign->enabled('families') && $model->family)
    <li class="list-group-item">
        <b>{{ __('characters.fields.family') }}</b>
        <span class="pull-right">
                        {!! $model->family->tooltipedLink() !!}
                    </span>
        <br class="clear" />
    </li>
@endif
@include('cruds.lists.location')
@if ($campaign->enabled('races') && $model->race)
    <li class="list-group-item">
        <b>{{ __('characters.fields.race') }}</b>
        <span class="pull-right">
                        {!! $model->race->tooltipedLink() !!}
                    </span>
        <br class="clear" />
    </li>
@endif
@if (!empty($model->type))
    <li class="list-group-item">
        <b>{{ __('characters.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
        <br class="clear" />
    </li>
@endif
