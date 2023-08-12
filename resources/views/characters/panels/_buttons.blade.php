@can('organisation', [$model, 'add'])
    <div class="header-buttons flex gap-2 items-center justify-end">
        <a href="{{ route('characters.character_organisations.create', [$campaign, $model]) }}"
            class="btn2 btn-sm btn-accent" data-toggle="ajax-modal"
            data-target="#entity-modal" data-url="{{ route('characters.character_organisations.create', [$campaign, $model]) }}">
            <x-icon class="plus"></x-icon>
            {!! \App\Facades\Module::singular(config('entities.ids.organisation'), __('entities.organisation')) !!}
        </a>
    </div>
@endcan
