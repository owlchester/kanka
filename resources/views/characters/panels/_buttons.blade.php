
<div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
    @can('update', $entity ?? $model->entity)
        <a href="{{ route('characters.character_organisations.create', [$campaign, $model]) }}"
            class="btn2 btn-sm" data-toggle="dialog"
            data-url="{{ route('characters.character_organisations.create', [$campaign, $model]) }}">
            <x-icon class="plus" />
            <span class="hidden lg:inline">{!! \App\Facades\Module::singular(config('entities.ids.organisation'), __('entities.organisation')) !!}</span>
        </a>
    @endcan
    @include('entities.headers.actions', ['edit' => false])
</div>


@section('modals')
    @parent
    <x-dialog id="organisation-dialog" :loading="true" />
@endsection
