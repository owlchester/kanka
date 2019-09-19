@if (config('entities.file_upload'))
<li class="list-group-item export-hidden">
        <b>{{ trans('crud.fields.files') }}
        @can('update', $model)
            <i class="fa fa-cloud-upload-alt pull-right entity-file-ui" data-url="{{ route('entities.entity_files.index', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('crud.files.actions.manage') }}"></i>
        @endif
        </b>

    <div class="entity-file-list" data-url="{{ route('entities.files', [$model->entity]) }}">
        @include('entities.components._files', ['entity' => $model->entity])
    </div>
</li>


@section('scripts')
    @parent
    <script src="{{ mix('js/entity.js') }}" defer></script>
    <script src="{{ mix('js/jquery.fileupload.js') }}" defer></script>
    <script src="{{ mix('js/jquery.iframe-transport.js') }}" defer></script>
    <script src="{{ mix('js/vendor/jquery.ui.widget.js') }}" defer></script>
@endsection
@endif