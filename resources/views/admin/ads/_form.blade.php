
{{ csrf_field() }}
<div class="panel panel-default">
    <div class="panel-body">
        <div class="form-group required">
            <label>Section</label>
            {!! Form::select('section', [
    \App\Models\Ad::SECTION_SIDEBAR => 'Sidebar',
    \App\Models\Ad::SECTION_BANNER => 'Banner',
    \App\Models\Ad::SECTION_FOOTER => 'Footer',
], old('section'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group required">
            <label>Customer</label>
            {!! Form::text('customer', old('customer'), ['placeholder' => 'Customer name', 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
        <div class="form-group required">
            <label>HTML</label>
            {!! Form::textarea('html', old('html'), ['placeholder' => 'HTML of the ad', 'class' => 'codemirror form-control', 'rows' => 3, 'id' => 'html', 'spellcheck' => 'false']) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('is_active', 0) !!}
            <label>
                {!! Form::checkbox('is_active') !!}
                Active
            </label>
        </div>
    </div>
</div>

@if(isset($model))
    <div class="pull-right">
        <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
           title="{{ __('crud.delete_modal.title') }}"
           data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => $model->name]) }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-ad-{{ $model->id}}'>{{ __('crud.remove') }}</a>">
            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
        </a>
    </div>
@endif

<button class="btn btn-success" id="form-submit-main" data-unsaved="{{ __('crud.hints.unsaved_changes') }}">{{ __('crud.save') }}</button>
@include('partials.or_cancel')


@section('modals')
    @parent
    @if(isset($model))
        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.ads.destroy', $model], 'style' => 'display:inline', 'id' => 'delete-ad-' . $model->id]) !!}
        {!! Form::close() !!}
    @endif
@endsection


@section('scripts')
    @parent
    <script src="/vendor/codemirror/lib/codemirror.js"></script>
    <script src="/vendor/codemirror/mode/xml/xml.js"></script>
    <script src="/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="/vendor/codemirror/addon/hint/show-hint.js"></script>
    <script src="/vendor/codemirror/addon/hint/html-hint.js"></script>
    <script src="/vendor/codemirror/addon/search/search.js"></script>
    <script src="/vendor/codemirror/addon/search/searchcursor.js"></script>
    <script src="/vendor/codemirror/addon/dialog/dialog.js"></script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="/vendor/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/vendor/codemirror/addon/hint/show-hint.css">
    <link rel="stylesheet" href="/vendor/codemirror/addon/dialog/dialog.css">
    <link rel="stylesheet" href="/vendor/codemirror/theme/dracula.css">
@endsection
