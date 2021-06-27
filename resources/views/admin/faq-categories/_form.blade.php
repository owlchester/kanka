
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

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ __('crud.save') }}</button>
@include('partials.or_cancel')
