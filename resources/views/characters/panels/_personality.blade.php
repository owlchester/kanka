<?php /** @var \App\Models\Character $model */
$traits = $model->characterTraits()->personality()->orderBy('default_order')->get();
?>

@if (((auth()->check() && auth()->user()->can('personality', $model)) || $model->is_personality_visible) && count($traits) > 0)
    <div class="box box-solid character-personalities">
        <div class="box-header with-border">
            <h3 class="box-title cursor entity-note-toggle" data-toggle="collapse" data-target="#character-personality-body" data-short="character-personality-toggle">
                <i class="fa fa-chevron-up" id="character-personality-toggle-show"></i>
                <i class="fa fa-chevron-down" id="character-personality-toggle-hide" style="display: none;"></i>
                {{ __('characters.sections.personality') }}
            </h3>
            @if(auth()->check() && auth()->user()->can('personality', $model))
                <div class="box-tools">
                    @if (!$model->is_personality_visible)
                        <i class="fa fa-lock" title="{{ __('characters.hints.personality_not_visible') }}" data-toggle="tooltip"></i>
                    @else
                        <i class="fa fa-lock-open" title="{{ __('characters.hints.personality_visible') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
            @endif
        </div>
        <div class="box-body collapse in" id="character-personality-body">
        @foreach ($traits as $trait)
            <p class="entity-trait-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                <b>{{ $trait->name }}</b><br />
                {!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}
            </p>
        @endforeach
        </div>
    </div>
@endif
