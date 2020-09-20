<?php /** @var \App\Models\MiscModel $model */?>
@section('entity-actions')
    <div class="entity-actions">
        @if (auth()->check() && !isset($exporting))
        <div class="actions text-right">
            <h1 class="hidden-xs pull-left">
                {{ $model->name }}
                @if ($model->is_private)
                    <i class="fas fa-lock" title="{{ __('crud.is_private') }}"></i>
                @endif
                @if ($model instanceof \App\Models\Character && $model->is_dead)
                    <span class="ra ra-skull" title="{{ __('characters.hints.is_dead') }}"></span>
                @endif
            </h1>

            @if ($model->entity)
            <div class="btn-group">
                <button class="btn btn-default" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-toggle="tooltip"
                    data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}]" data-success="#copy-mention-success">
                    <i class="fa fa-link"></i> <span class="hidden-xs">{{ __('crud.actions.copy_mention') }}</span>
                </button>
            </div>
            @endif

            @if (config('entities.file_upload') && $model->entity && $model->entity->hasFiles())
                <div class="btn-group">
                    @can('update', $model)
                        <button type="button" class="btn btn-default entity-file-ui" data-url="{{ route('entities.entity_files.index', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('crud.files.actions.manage') }}">
                    @else
                        <button type="button" class="btn btn-default">
                    @endif
                        <i class="fa fa-cloud-upload-alt"></i> <span class="hidden-xs">{{ __('crud.fields.files') }}</span>

                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $model->entity->files->count() }}
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @foreach ($model->entity->files as $file)
                            <li>
                                <a href="{{ Storage::url($file->path) }}" target="_blank" class="entity-file">
                                    {{ $file->name }}
                                </a>
                            </li>
                        @endforeach
                        @if ($model->entity->files->count() == 0)
                            <li>
                                <a>{{ __('crud.files.errors.no_files') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif

            @can('permission', $model)
                <div class="btn-group">
                    <a href="{{ route('entities.permissions', $model->entity) }}" data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ route('entities.permissions', $model->entity) }}" class="btn btn-default">
                        <i class="fa fa-cog"></i> <span class="hidden-xs">{{ __('crud.tabs.permissions') }}</span>
                    </a>
                    @if (Auth::user()->isAdmin())
                    <button type="button" class="btn btn-default entity-private-toggle" data-url="{{ route('entities.privacy.toggle', $model->entity) }}">
                        <i class="fa fa-{{ ($model->is_private ? 'lock' : 'unlock') }}" data-on="lock" data-off="unlock" title="{{ __('crud.is_' . ($model->is_private ? '' : 'not_') . 'private') }}" data-title-on="{{ __('crud.is_private') }}" data-title-off="{{ __('crud.is_not_private') }}"></i>
                    </button>
                    @endif
                </div>
            @endcan

                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="hidden-xs">{{ __('crud.actions.actions') }}</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        @can('create', $model)
                            <li>
                                <a href="{{ route($name . '.create') }}">
                                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('crud.actions.new') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route($name . '.create', ['copy' => $model->id]) }}">
                                    <i class="fa fa-copy" aria-hidden="true"></i> {{ __('crud.actions.copy') }}
                                </a>
                            </li>
                        @endcan
                        @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && Auth::check() && Auth::user()->hasOtherCampaigns($model->campaign_id))
                            <li>
                                <a href="{{ route('entities.copy_to_campaign', $model->entity->id) }}">
                                    <i class="fa fa-clone" aria-hidden="true"></i> {{ __('crud.actions.copy_to_campaign') }}
                                </a>
                            </li>
                        @endif

                        @if ((empty($disableMove) || !$disableMove) && Auth::user()->can('move', $model))
                            <li>
                                <a href="{{ route('entities.move', $model->entity->id) }}">
                                    <i class="fa fa-exchange-alt" aria-hidden="true"></i> {{ __('crud.actions.move') }}
                                </a>
                            </li>
                        @endif

                        @if ($model->entity)
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('entities.template', $model->entity) }}">
                                        @if($model->entity->is_template)
                                            <i class="fa fa-star-o" aria-hidden="true"></i> {{ __('entities/actions.templates.unset') }}
                                        @else
                                            <i class="fa fa-star-o" aria-hidden="true"></i> {{ __('entities/actions.templates.set') }}
                                        @endif
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('entities.export', $model->entity) }}">
                                    <i class="fa fa-download" aria-hidden="true"></i> {{ __('crud.actions.export') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('entities.json-export', $model->entity) }}">
                                    <i class="fa fa-download" aria-hidden="true"></i> {{ trans('crud.actions.json-export') }}
                                </a>
                            </li>
                        @endif
                        @can('delete', $model)
                            <li class="divider"></li>
                            <li>
                                <a href="#" class="delete-confirm text-red" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                                    <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE','route' => [$name . '.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endcan
                    </ul>
                </div>

                @can('update', $model)
                    <div class="btn-group">
                        <a href="{{ route($name . '.edit', [$model]) }}" class="btn btn-primary">
                            <i class="fa fa-edit" aria-hidden="true"></i> <span class="hidden-xs">{{ __('crud.edit') }}</span>
                        </a>
                    </div>
                @endcan

        </div>
        @endif
    </div>

    <div class="alert alert-info collapse" id="copy-mention-success" role="alert">
        {{ __('crud.alerts.copy_mention') }}
    </div>
@endsection


@section('scripts')
    @parent
    @if (auth()->check() && config('entities.file_upload'))
        <script src="{{ mix('js/entity.js') }}" defer></script>
        <script src="{{ mix('js/jquery.fileupload.js') }}" defer></script>
        <script src="{{ mix('js/jquery.iframe-transport.js') }}" defer></script>
        <script src="{{ mix('js/vendor/jquery.ui.widget.js') }}" defer></script>
    @endif
@endsection
