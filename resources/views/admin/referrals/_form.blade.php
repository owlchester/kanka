
{{ csrf_field() }}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>Code</label>
                    {!! Form::text('code', old('code'), ['placeholder' => 'code with no spaces', 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>
                <div class="form-group">
                    {!! Form::hidden('is_valid', false) !!}
                    <label>Active</label>
                    {!! Form::checkbox('is_valid') !!}
                </div>
            </div>
        </div>

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ __('crud.save') }}</button>
{!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
