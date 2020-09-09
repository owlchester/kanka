
{{ csrf_field() }}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ __('admin/community-events.fields.name') }}</label>
                    {!! Form::text('name', old('name'), ['placeholder' => __('admin/community-events.fields.name'), 'class' => 'form-control', 'maxlength' => 191, 'required']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('admin/community-events.fields.content') }}</label>
                    {!! Form::textarea('entry', old('entry'), ['placeholder' => __('admin/community-events.fields.entry'), 'class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry', 'required']) !!}
                </div>
                <div class="form-group required">
                    <label>{{ __('admin/community-events.fields.excerpt') }}</label>
                    {!! Form::textarea('excerpt', old('excerpt'), ['placeholder' => __('admin/community-events.fields.excerpt'), 'class' => 'form-control', 'rows' => 3]) !!}
                </div>

                <div class="">
                    <label>{{ __('crud.fields.image') }}</label>
                    {!! Form::hidden('remove-image') !!}
                </div>

                <div class="row">
                    <div class="{{ empty($model->image) ? 'col-md-12' : 'col-md-10' }}">
                        <div class="form-group">
                            {!! Form::file('image', array('class' => 'image form-control')) !!}
                        </div>
                    </div>
                    @if (!empty($model->image))
                        <div class="col-md-2">
                            <div class="preview-v2">
                                <div class="image" style="background-image: url('{{ $model->getImageUrl(200, 120) }}')" title="{{ $model->name }}">
                                    <a href="#" class="img-delete" data-target="remove-image" title="{{ __('crud.remove') }}">
                                        <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label>{{ __('admin/community-events.fields.start_at') }}</label>
                            <div class="input-group">
                                {!! Form::text('start_at', old('start_at'), ['placeholder' => __('admin/community-events.fields.start_at'), 'class' => 'form-control datetime-picker', 'maxlength' => 25, 'required']) !!}
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label>{{ __('admin/community-events.fields.end_at') }}</label>
                            <div class="input-group">
                                {!! Form::text('end_at', old('end_at'), ['placeholder' => __('admin/community-events.fields.end_at'), 'class' => 'form-control datetime-picker', 'maxlength' => 25, 'required']) !!}
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
