
<article class="bg-box rounded box-entity-entry">
    @if ($model->hasEntry())
    <div class="p-4 entity-content">
        @if (auth()->check())
            @can('update', [$model])
                <div class="float-right ml-2 mb-2">
                    <a href="{{ route('entities.entry.edit', [$campaign, $model->entity]) }}" data-title="{{ __('crud.edit') }}" role="button" class="" data-toggle="tooltip">
                        <x-icon class="edit"></x-icon>
                        <span class="sr-only">{{ __('crud.edit') }}</span>
                    </a>
                </div>
            @endcan
        @endif
        {!! $model->entry() !!}
    </div>
    @endif
</article>

@includeWhen($model instanceof \App\Models\Character && $model->is_appearance_pinned, 'characters.panels._appearance')
@includeWhen($model instanceof \App\Models\Character && $model->is_personality_pinned, 'characters.panels._personality')


