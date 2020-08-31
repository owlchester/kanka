<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')
        @endif

        <ul class="list-group list-group-unbordered">
            @include('cruds.lists.location')
            @include('cruds.lists.type')

            @if (!empty($model->organisation))
                <li class="list-group-item">
                    <b>{{ trans('crud.fields.organisation') }}</b>
                    <span class="pull-right">
                        {!! $model->organisation->tooltipedLink() !!}
                    </span>
                    <br class="clear" />
                </li>
            @endif

            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
        </ul>
    </div>
</div>

@include('entities.components.menu')
@include('entities.components.actions')
