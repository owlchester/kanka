<div class="box">
    <div class="box-body box-profile">
        @include ('cruds._image')
        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->type))
                <li class="list-group-item">
                    <b>{{ trans('conversations.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            <li class="list-group-item">
                <b>{{ trans('conversations.fields.target') }}</b>
                <span class="pull-right">
                            {{ trans('conversations.targets.' . $model->target) }}
                        </span>
                <br class="clear" />
            </li>
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions')
    </div>
</div>
@include('entities.components.menu')