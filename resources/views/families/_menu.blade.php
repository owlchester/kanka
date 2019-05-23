<div class="box box-solid">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->family))
                <li class="list-group-item">
                    <b>{{ trans('families.fields.family') }}</b>
                    <span class="pull-right">
                        <a href="{{ $model->family->getLink() }}" data-toggle="tooltip" title="{{ $model->family->tooltipWithName() }}" data-html="true">{{ $model->family->name }}</a>
                    </span>
                    <br class="clear" />
                </li>
            @endif

            @include('cruds.lists.location')
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions')
    </div>
</div>


@include('entities.components.menu')