
{{ csrf_field() }}
<div class="panel panel-default">
    <div class="panel-body">
        <div class="form-group required">
            <label>{{ __('admin/releases.fields.name') }}</label>
            {!! Form::text('name', old('name'), ['placeholder' => __('admin/releases.fields.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group required">
            <label>{{ __('admin/releases.fields.excerpt') }}</label>
            {!! Form::textarea('excerpt', old('excerpt'), ['placeholder' => __('admin/releases.fields.excerpt'), 'class' => 'form-control', 'rows' => 3]) !!}
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group required">
                    <label>{{ __('admin/releases.fields.link') }}</label>
                    {!! Form::text('link', old('link'), ['placeholder' => __('admin/releases.fields.link'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group required">
                    <label>{{ __('admin/releases.fields.category') }}</label>
                    {!! Form::select('category_id', [
    \App\Models\AppRelease::CATEGORY_RELEASE => __('releases.categories.release'),
    \App\Models\AppRelease::CATEGORY_EVENT => __('releases.categories.event'),
    \App\Models\AppRelease::CATEGORY_VOTE => __('releases.categories.vote'),
    \App\Models\AppRelease::CATEGORY_LIVESTREAM => __('releases.categories.livestream'),
    \App\Models\AppRelease::CATEGORY_OTHER => __('releases.categories.other')
    ], old('category_id'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group required">
                    <label>{{ __('admin/releases.fields.published_at') }}</label>
                    <div class="input-group">
                        {!! Form::text('published_at', old('published_at'), ['placeholder' => __('admin/releases.fields.published_at'), 'class' => 'form-control datetime-picker', 'maxlength' => 25]) !!}
                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __('admin/releases.fields.end_at') }}</label>
                    <div class="input-group">
                        {!! Form::text('end_at', old('end_at'), ['placeholder' => __('admin/releases.fields.end_at'), 'class' => 'form-control datetime-picker', 'maxlength' => 25]) !!}
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
    @parent
    @if(isset($model))
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.app-releases.destroy', $model], 'style' => 'display:inline', 'id' => 'delete-form-vote-' . $model->id]) !!}
        {!! Form::close() !!}
    @endif
@endsection
