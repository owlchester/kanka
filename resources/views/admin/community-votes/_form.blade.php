
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
    @if(isset($model))
    {!! Form::open(['method' => 'DELETE', 'route' => ['admin.community-votes.destroy', $model], 'style' => 'display:inline', 'id' => 'delete-form-vote-' . $model->id]) !!}
    {!! Form::close() !!}
    @endif
@endsection
