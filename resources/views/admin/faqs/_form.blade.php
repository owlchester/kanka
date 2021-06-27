
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('faq.fields.category') }}</label>
                    {!! Form::select('faq_category_id', \App\Models\FaqCategory::orderBy('title')->pluck('title', 'id')->toArray(), old('faq_category_id'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ trans('faq.fields.question') }}</label>
                    {!! Form::text('question', old('question'), ['placeholder' => trans('faq.fields.question'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group required">
                    <label>{{ trans('faq.fields.answer') }}</label>
                    {!! Form::textarea('answer', old('answer'), ['placeholder' => trans('faq.fields.answer'), 'class' => 'form-control html-editor']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ trans('faq.fields.order') }}</label>
                    {!! Form::number('order', old('order'), ['placeholder' => trans('faq.fields.order'), 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::hidden('locale', 'en') !!}

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ trans('crud.save') }}</button>
@include('partials.or_cancel')
