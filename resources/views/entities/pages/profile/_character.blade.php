<?php /** @var \App\Models\Character $model */
$appearances = $model->characterTraits()->appearance()->orderBy('default_order')->get();
$traits = $model->characterTraits()->personality()->orderBy('default_order')->get();

?>
    <x-grid type="1/1">
        <x-box class="box-entity-profile flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-6 gap-5">
                @if ($model->title)
                    <p class="entity-character-title">
                        <b>{{ __('characters.fields.title') }}</b><br />
                        {!! $model->title !!}
                    </p>
                @endif

                @if ($entity->type)
                    <p class="entity-type">
                        <b>{{ __('crud.fields.type') }}</b><br />
                        {!! $entity->type !!}
                    </p>
                @endif

                @if ($campaign->enabled('races') && !$model->characterRaces->isEmpty())
                    @php $existingRaces = []; @endphp
                    @foreach ($model->characterRaces as $race)
                        @if(!empty($existingRaces[$race->race_id]))
                            @continue
                        @endif
                        @php $existingRaces[$race->race_id] = true; @endphp
                    <p class="entity-race" data-foreign="{{ $race->race_id }}">
                        <b>{{ __('entities.race') }}</b><br />

                        <x-entity-link
                            :entity="$race->race->entity"
                            :campaign="$campaign" />
                    </p>
                    @endforeach
                @endif
                @if ($campaign->enabled('families') && !$model->characterFamilies->isEmpty())
                    @php $existingFamilies = []; @endphp
                    @foreach ($model->characterFamilies as $family)
                        @if(!empty($existingFamilies[$family->family_id]))
                            @continue
                        @endif
                        @php $existingFamilies[$family->family_id] = true; @endphp
                        <p class="entity-family" data-foreign="{{ $family->family_id }}">
                            <b>{{ __('entities.families') }}</b><br />
                            <x-entity-link
                                :entity="$family->family->entity"
                                :campaign="$campaign" />
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
                        {!! $model->sex !!}
                    </p>
                @endif

                @if ($model->pronouns)
                    <p class="entity-pronouns">
                        <b>{{ __('characters.fields.pronouns') }}</b><br />
                        {!! $model->pronouns !!}
                    </p>
                @endif
            </div>

            <ul class="m-0 p-0">
                @include('entities.components.elasped_events')
            </ul>
        </x-box>

        @if (count($appearances) > 0)
            <div class="character-appearances flex flex-col gap-4 md:gap-6">
                <h4 class="">{{ __('characters.sections.appearance') }}</h4>
                <x-box class="character-appearances grid grid-cols-2 gap-5">
                    @foreach ($appearances as $trait)
                        <p class="entity-appearance-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                            <b>{{ $trait->name }}</b><br />
                            {{ $trait->entry }}
                        </p>
                    @endforeach
                </x-box>
            </div>
        @endif

        @if (((auth()->check() && auth()->user()->can('personality', $model)) || $model->is_personality_visible) && count($traits) > 0)

            <div class="character-personalities flex flex-col gap-4 md:gap-6">
                <div class="flex items-center justify-between gap-2">
                    <h4 >{{ __('characters.sections.personality') }}</h4>
                    @can('personality', $model)
                        @if (!$model->is_personality_visible)
                            <x-icon class="lock" tooltip :title="__('characters.hints.personality_not_visible')" />
                        @else
                            <x-icon class="fa-regular fa-lock-open" tooltip :title="__('characters.hints.personality_visible')" />
                        @endif
                    @endif
                </div>
                <x-box class="flex flex-col gap-5">

                @foreach ($traits as $trait)
                    <p class="entity-trait-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                        <b>{{ $trait->name }}</b><br />
                        {!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}
                    </p>
                @endforeach
            </x-box>
        @endif
    </x-grid>


