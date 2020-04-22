
{{ csrf_field() }}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ __('admin/community-votes.fields.name') }}</label>
                    {!! Form::text('name', old('name'), ['placeholder' => __('admin/community-votes.fields.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('admin/community-votes.fields.content') }}</label>
                    {!! Form::textarea('content', old('content'), ['placeholder' => __('admin/community-votes.fields.content'), 'class' => 'form-control html-editor', 'id' => 'content', 'name' => 'content']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('admin/community-votes.fields.excerpt') }}</label>
                    {!! Form::textarea('excerpt', old('excerpt'), ['placeholder' => __('admin/community-votes.fields.excerpt'), 'class' => 'form-control', 'rows' => 3]) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('admin/community-votes.fields.options') }}</label>
                    {!! Form::textarea('options', old('options'), ['placeholder' => __('admin/community-votes.fields.options'), 'class' => 'form-control']) !!}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('admin/community-votes.fields.visible_at') }}</label>
                            <div class="input-group">
                                {!! Form::text('visible_at', old('visible_at'), ['placeholder' => __('admin/community-votes.fields.visible_at'), 'class' => 'form-control datetime-picker', 'maxlength' => 25]) !!}
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('admin/community-votes.fields.published_at') }}</label>
                            <div class="input-group">
                                {!! Form::text('published_at', old('published_at'), ['placeholder' => __('admin/community-votes.fields.published_at'), 'class' => 'form-control datetime-picker', 'maxlength' => 25]) !!}
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
