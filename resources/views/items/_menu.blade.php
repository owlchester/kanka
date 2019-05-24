<div class="box box-solid">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

        <ul class="list-group list-group-unbordered">
            @if ($model->type)
                <li class="list-group-item">
                    <b>{{ trans('items.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @include('cruds.lists.location')
            @if ($campaign->enabled('characters') && !empty($model->character))
                <li class="list-group-item">
                    <b>{{ trans('items.fields.character') }}</b>
                    <span  class="pull-right">
                            <a href="{{ $model->character->getLink() }}" data-toggle="tooltip" title="{{ $model->character->tooltipWithName() }}" data-html="true">{{ $model->character->name }}</a>
                            </span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->price)
                <li class="list-group-item">
                    <b>{{ trans('items.fields.price') }}</b> <span class="pull-right">{{ $model->price }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->size)
                <li class="list-group-item">
                    <b>{{ trans('items.fields.size') }}</b> <span class="pull-right">{{ $model->size }}</span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.attributes')
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions')
    </div>
</div>

@include('entities.components.menu')