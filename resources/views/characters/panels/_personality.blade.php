<?php /** @var \App\Models\Character $model */
$traits = $model->personality;
?>

@if (((auth()->check() && auth()->user()->can('personality', $model)) || $model->is_personality_visible) && count($traits) > 0)

    <div class="flex flex-col gap-3 post-block character-personalities">
        <div class="post-header flex gap-1 md:gap-2 items-center">
            <div class="flex gap-2 items-center grow cursor-pointer element-toggle" data-animate="collapse" data-target="#character-personality-body">
                <x-icon class="fa-solid fa-chevron-up icon-show" />
                <x-icon class="fa-solid fa-chevron-down icon-hide" />
                <h3 class="post-title grow m-0">
                    {{ __('characters.sections.personality') }}
                </h3>
            </div>
            @if(auth()->check() && auth()->user()->can('personality', $model))
                <div class="flex-none w-6">
                    @if (!$model->is_personality_visible)
                        <x-icon class="fa-solid fa-lock" tooltip title="{{ __('characters.hints.personality_not_visible') }}" />
                    @else
                        <x-icon class="fa-solid fa-lock-open" tooltip title="{{ __('characters.hints.personality_visible') }}" />
                    @endif
                </div>
            @endif
        </div>
        <div class="bg-box rounded" id="character-personality">
            <div class="entity-content overflow-hidden" id="character-personality-body">
                <div class="p-4">
                    @foreach ($traits as $trait)
                        <p class="entity-trait-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                            <b>{{ $trait->name }}</b><br />
                            {!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
