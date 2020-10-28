
{{ csrf_field() }}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ __('admin/releases.fields.name') }}</label>
                    {!! Form::text('name', old('name'), ['placeholder' => __('admin/releases.fields.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('admin/releases.fields.excerpt') }}</label>
                    {!! Form::text('excerpt', old('excerpt'), ['placeholder' => __('admin/releases.fields.excerpt'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('admin/releases.fields.link') }}</label>
                    {!! Form::text('link', old('link'), ['placeholder' => __('admin/releases.fields.link'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('admin/releases.fields.published_at') }}</label>
                            <div class="input-group">
                                {!! Form::text('published_at', old('published_at'), ['placeholder' => __('admin/releases.fields.visible_at'), 'class' => 'form-control datetime-picker', 'maxlength' => 25]) !!}
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ __('crud.save') }}</button>
{!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
