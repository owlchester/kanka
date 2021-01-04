<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')
            @include('entities.components.links')
        @endif

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->type))
                <li class="list-group-item">
                    <b>{{ trans('notes.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if (!empty($model->note))
                <li class="list-group-item">
                    <b>{{ __('notes.fields.note') }}
                    </b>

                    <span class="pull-right">
                    {!! $model->note->tooltipedLink() !!}
                        </span>
                    <br class="clear" />
                </li>
            @endif

            @if(!$model->notes->isEmpty())
                <li class="list-group-item">
                    <b>{{ __('notes.fields.notes') }}</b>
                    <div class="text-center">
                    @foreach ($model->notes->sortBy('name') as $subNote)
                        {!! $subNote->tooltipedLink() !!}<br />
                    @endforeach
                    </div>
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
