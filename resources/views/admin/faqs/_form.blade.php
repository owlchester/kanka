
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ __('Category') }}</label>
                    {!! Form::select('faq_category_id', \App\Models\FaqCategory::orderBy('title')->pluck('title', 'id')->toArray(), old('faq_category_id'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('Question') }}</label>
                    {!! Form::text('question', old('question'), ['placeholder' => __('Question'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('Answer') }}</label>
                    {!! Form::textarea('answer', old('answer'), ['placeholder' => __('Answer'), 'class' => 'form-control html-editor']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('Order') }}</label>
                    {!! Form::number('order', old('order'), ['placeholder' => __('Order'), 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::hidden('locale', 'en') !!}


@if(isset($model))
    <div class="pull-right">
        <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
           title="{{ __('crud.delete_modal.title') }}"
           data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => $model->question]) }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-faq-{{ $model->id}}'>{{ __('crud.remove') }}</a>">
            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
        </a>
    </div>
@endif


<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ __('crud.save') }}</button>
@include('partials.or_cancel')


@section('modals')
    @parent
    @if(isset($model))
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.faqs.destroy', $model], 'style' => 'display:inline', 'id' => 'delete-faq-' . $model->id]) !!}
        {!! Form::close() !!}
    @endif
@endsection
