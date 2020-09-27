<div class="panel panel-default">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
        <h4>{{ trans('crud.files.title', ['name' => $entity->name]) }}</h4>
    </div>
    <div class="panel-body panel-entity-files">

        <form method="post" action="{{ route('entities.entity_files.store', $entity) }}" enctype="multipart/form-data" style="display: none">
            {{ csrf_field() }}
            <input id="entity-file-upload" type="file" name="file" data-url="{{ route('entities.entity_files.store', $entity) }}" multiple>
        </form>
        <div class="entity-files-drop well" style="{{ $enabled ? '' : 'display:none' }}">
            <b>{{ __('crud.files.actions.drop') }}</b><br />
            {{ trans('crud.files.hints.limitations', ['formats' => 'jpg, png, gif, pdf, xls(x), mp3, ogg', 'size' => auth()->user()->maxUploadSize(true)]) }}
            @if (!\App\Facades\CampaignLocalization::getCampaign()->boosted() && !auth()->user()->hasRole('patreon'))
                <p><a href="{{ route('settings.subscription') }}" target="_blank">{{ __('crud.hints.image_patreon') }}</a></p>
            @endif
        </div>
        <div class="progress" style="display: none">
            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                <span class="sr-only"></span>
            </div>
        </div>
        <div class="entity-file-upload-error text-red" style="display: none"></div>
        <div class="entity-file-upload-max text-red well" style="{{ $enabled ? 'display:none' : '' }}">
            {{ __('crud.files.errors.max', ['max' => $campaign->maxEntityFiles()]) }}
        </div>

        <div class="entity-files">
        @include('cruds.files.files')
        </div>
    </div>
</div>
