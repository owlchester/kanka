<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')

            <h1 class="profile-username text-center">{{ $model->name }}
                @if ($model->is_private)
                    <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
                @endif
            </h1>
        @endif

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
                        {!! $model->character->tooltipedLink() !!}
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
            @if ($model->weight)
                <li class="list-group-item">
                    <b>{{ trans('items.fields.weight') }}</b> <span class="pull-right">{{ $model->weight }}</span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>

        @include('.cruds._actions')
    </div>
</div>

@include('entities.components.menu')
