@if(Auth::check() && !isset($exporting))
    @can('update', $model)
        <a href="{{ route($name . '.edit', [$model]) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit" aria-hidden="true"></i> {{ trans('crud.update') }}
        </a>
    @endcan
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span></span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            @can('create', $model)
            <li>
                <a href="{{ route($name . '.create') }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('crud.actions.new') }}
                </a>
            </li>
            <li>
                <a href="{{ route($name . '.create', ['copy' => $model->id]) }}">
                    <i class="fa fa-copy" aria-hidden="true"></i> {{ trans('crud.actions.copy') }}
                </a>
            </li>
            @endcan
            @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && getenv('APP_ENV') !== 'shadow' && Auth::check() && Auth::user()->hasOtherCampaigns($model->campaign_id))
                <li>
                    <a href="{{ route('entities.copy_to_campaign', $model->entity->id) }}">
                        <i class="fa fa-clone" aria-hidden="true"></i> {{ trans('crud.actions.copy_to_campaign') }}
                    </a>
                </li>
            @endif

            @if ((empty($disableMove) || !$disableMove) && getenv('APP_ENV') !== 'shadow' && Auth::user()->can('move', $model))
            <li>
                <a href="{{ route('entities.move', $model->entity->id) }}">
                    <i class="fa fa-exchange-alt" aria-hidden="true"></i> {{ trans('crud.actions.move') }}
                </a>
            </li>
            @endif

            @if ($model->entity)
            <li>
                <a href="{{ route('entities.export', $model->entity) }}">
                    <i class="fa fa-download" aria-hidden="true"></i> {{ trans('crud.actions.export') }}
                </a>
            </li>
            @endif
            @can('delete', $model)
            <li class="divider"></li>
            <li>
                <a href="#" class="delete-confirm text-red" data-name="{{ $model->name }}" data-toggle="modal" data-target="#delete-confirm">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </a>
                {!! Form::open(['method' => 'DELETE','route' => [$name . '.destroy', $model->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                {!! Form::close() !!}
            </li>
            @endcan
        </ul>
    </div>
@endif
