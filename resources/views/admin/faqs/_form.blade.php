
{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('faq.fields.locale') }}</label>
                    {!! Form::select('locale', trans('languages.codes'), old('locale'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ trans('faq.fields.question') }}</label>
                    {!! Form::text('question', old('question'), ['placeholder' => trans('faq.fields.question'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group required">
                    <label>{{ trans('faq.fields.answer') }}</label>
                    {!! Form::textarea('answer', old('answer'), ['placeholder' => trans('faq.fields.answer'), 'class' => 'form-control']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ trans('faq.fields.order') }}</label>
                    {!! Form::number('order', old('order'), ['placeholder' => trans('faq.fields.order'), 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="faq_category_id" value="1" />

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ trans('crud.save') }}</button>
@include('partials.or_cancel')
