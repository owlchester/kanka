
{{ csrf_field() }}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ __('crud.fields.name') }}</label>
                    {!! Form::text('title', old('title'), ['placeholder' => 'Maps, Timelines, Resources', 'class' => 'form-control', 'maxlength' => 191, 'required']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('crud.fields.position') }}</label>
                    {!! Form::number('order', old('order'), ['class' => 'form-control', 'maxlength' => 3, 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::hidden('is_visible', 0) !!}
                    <label>
                        {!! Form::checkbox('is_visible') !!}
                        {{ __('admin/faqs.categories.fields.visible') }}</label>
                </div>

                {!! Form::hidden('locale', 'en') !!}
            </div>
        </div>

@if(isset($model))
    <div class="pull-right">
        <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
           title="{{ __('crud.delete_modal.title') }}"
           data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => $model->name]) }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-vote-{{ $model->id}}'>{{ __('crud.remove') }}</a>">
            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
        </a>
    </div>
@endif

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ __('crud.save') }}</button>
@include('partials.or_cancel')


@section('modals')
    @parent
    @if(isset($model))
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.faq-categories.destroy', $model], 'style' => 'display:inline', 'id' => 'delete-form-vote-' . $model->id]) !!}
        {!! Form::close() !!}
    @endif
@endsection
