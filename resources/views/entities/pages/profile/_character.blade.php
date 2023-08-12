<?php /** @var \App\Models\Character $model */
$appearances = $model->characterTraits()->appearance()->orderBy('default_order')->get();
$traits = $model->characterTraits()->personality()->orderBy('default_order')->get();
?>
<x-box css="box-entity-profile">
    <div class="flex w-full gap-5">
        <div class="flex-1">
            @if ($model->title)
                <p class="entity-character-title">
                    <b>{{ __('characters.fields.title') }}</b><br />
                    {{ $model->title }}
                </p>
            @endif

            @if ($model->type)
                <p class="entity-type">
                    <b>{{ __('crud.fields.type') }}</b><br />
                    {{ $model->type }}
                </p>
            @endif

            @if ($campaign->enabled('races') && !$model->races->isEmpty())
                @php $existingRaces = []; @endphp
                @foreach ($model->races as $race)
                    @if(!empty($existingRaces[$race->id]))
                        @continue
                    @endif
                    @php $existingRaces[$race->id] = true; @endphp
                <p class="entity-race" data-foreign="{{ $race->id }}">
                    <b>{{ __('entities.race') }}</b><br />
                    {!! $race->tooltipedLink() !!}
                </p>
                @endforeach
            @endif
            @if ($campaign->enabled('families') && !$model->families->isEmpty())
                @php $existingFamilies = []; @endphp
                @foreach ($model->families as $family)
                    @if(!empty($existingFamilies[$family->id]))
                        @continue
                    @endif
                    @php $existingFamilies[$family->id] = true; @endphp
                    <p class="entity-family" data-foreign="{{ $family->id }}">
                        <b>{{ __('entities.families') }}</b><br />
                        {!! $family->tooltipedLink() !!}
                    </p>
                @endforeach
            @endif

            @if ($model->age || $model->age === '0')
                <p class="entity-age">
                    <b>{{ __('characters.fields.age') }}</b><br />
                    {{ $model->age }}
                </p>
            @endif

            @if ($model->sex)
                <p class="entity-gender">
                    <b>{{ __('characters.fields.sex') }}</b><br />
                    {{ $model->sex }}
                </p>
            @endif

            @if ($model->pronouns)
                <p class="entity-pronouns">
                    <b>{{ __('characters.fields.pronouns') }}</b><br />
                    {{ $model->pronouns }}
                </p>
            @endif
        </div>

        @if (count($appearances) > 0)
            <div class="character-appearances flex-1">
                @foreach ($appearances as $trait)
                    <p class="entity-appearance-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                        <b>{{ $trait->name }}</b><br />
                        {{ $trait->entry }}
                    </p>
                @endforeach
            </div>
        @endif

        @if (((auth()->check() && auth()->user()->can('personality', $model)) || $model->is_personality_visible) && count($traits) > 0)
            <div class="character-personalities flex-1">

                @if(auth()->check() && auth()->user()->can('personality', $model))
                    <span class="pull-right">
                        @if (!$model->is_personality_visible)
                            <i class="fa-solid fa-lock" title="{{ __('characters.hints.personality_not_visible') }}" data-toggle="tooltip"></i>
                        @else
                            <i class="fa-solid fa-lock-open" title="{{ __('characters.hints.personality_visible') }}" data-toggle="tooltip"></i>
                        @endif
                    </span>
                @endif

                @foreach ($traits as $trait)
                    <p class="entity-trait-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                        <b>{{ $trait->name }}</b><br />
                        {!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}
                    </p>
                @endforeach
            </div>
        @endif
    </div>

    <ul class="m-0 p-0">
        @include('entities.components.elasped_events')
    </ul>
</x-box>


