<?php /** @var \App\Models\Character $model */
$appearances = $model->characterTraits()->appearance()->orderBy('default_order')->get();
$traits = $model->characterTraits()->personality()->orderBy('default_order')->get();
?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->title)
                    <p>
                        <b>{{ __('characters.fields.title') }}</b><br />
                        {{ $model->title }}
                    </p>
                @endif

                @if ($model->type)
                    <p>
                        <b>{{ __('characters.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif

                @if ($campaign->enabled('races') && $model->race)
                    <p>
                        <b>{{ __('characters.fields.race') }}</b><br />
                        {!! $model->race->tooltipedLink() !!}
                    </p>
                @endif

                @if ($campaign->enabled('families') && $model->family)
                    <p>
                        <b>{{ __('characters.fields.family') }}</b><br />
                        {!! $model->family->tooltipedLink() !!}
                    </p>
                @endif

                @if ($model->age || $model->age === '0')
                    <p>
                        <b>{{ __('characters.fields.age') }}</b><br />
                        {{ $model->age }}
                    </p>
                @endif

                @if ($model->sex)
                    <p>
                        <b>{{ __('characters.fields.sex') }}</b><br />
                        {{ $model->sex }}
                    </p>
                @endif

                @if ($model->pronouns)
                    <p>
                        <b>{{ __('characters.fields.pronouns') }}</b><br />
                        {{ $model->pronouns }}
                    </p>
                @endif
            </div>

            @if (count($appearances) > 0)
                <div class="col-md-3">

                    @foreach ($appearances as $trait)
                        <p>
                            <b>{{ $trait->name }}</b><br />
                            {{ $trait->entry }}
                        </p>
                    @endforeach
                </div>
            @endif

            @if (((auth()->check() && auth()->user()->can('personality', $model)) || $model->is_personality_visible) && count($traits) > 0)
                <div class="col-md-5">

                    @if(auth()->check() && auth()->user()->can('personality', $model))
                        <span class="pull-right">
                            @if (!$model->is_personality_visible)
                                <i class="fa fa-lock" title="{{ __('characters.hints.personality_not_visible') }}" data-toggle="tooltip"></i>
                            @else
                                <i class="fa fa-lock-open" title="{{ __('characters.hints.personality_visible') }}" data-toggle="tooltip"></i>
                            @endif
                        </span>
                    @endif

                    @foreach ($traits as $trait)
                        <p>
                            <b>{{ $trait->name }}</b><br />
                            {!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@include('entities.components.elasped_events')

