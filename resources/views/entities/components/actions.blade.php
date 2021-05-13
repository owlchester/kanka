<?php /** @var \App\Models\MiscModel $model */?>
@section('entity-actions')
    <div class="entity-actions">
        @if (auth()->check() && !isset($exporting))
        <div class="actions text-right">



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
    <div class="alert alert-info collapse" id="copy-attribute-success" role="alert">
        {{ __('crud.alerts.copy_attribute') }}
    </div>
@endsection

