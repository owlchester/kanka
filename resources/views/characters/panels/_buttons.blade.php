@can('organisation', [$model, 'add'])
    <div class="header-buttons flex gap-2 items-center justify-end">
        <a href="{{ route('characters.character_organisations.create', [$campaign, $model]) }}"
            class="btn2 btn-sm btn-accent" data-toggle="dialog-ajax"
            data-target="organisation-dialog" data-url="{{ route('characters.character_organisations.create', [$campaign, $model]) }}">
            <x-icon class="plus"></x-icon>
            {!! \App\Facades\Module::singular(config('entities.ids.organisation'), __('entities.organisation')) !!}
        </a>
    </div>
@endcan


@section('modals')
    @parent
    <x-dialog id="organisation-dialog" :loading="true" />
@endsection
