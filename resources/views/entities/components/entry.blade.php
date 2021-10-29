
<div class="box box-solid box-entity-entry">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('crud.fields.entry') }}</h3>

        <div class="box-tools">
            @if (auth()->check())
                @can('update', [$model])
                    <a href="{{ route('entities.entry.edit', $model->entity) }}" title="{{ __('crud.edit') }}" role="button" class="btn btn-box-tool">
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan
            @endif
        </div>
    </div>
    @if ($model->hasEntry())
    <div class="box-body entity-content">
        {!! $model->entry() !!}
    </div>
    @endif
</div>



@if(auth()->check() && auth()->user()->can('update', $model))
@include('editors.editor')
@endif

