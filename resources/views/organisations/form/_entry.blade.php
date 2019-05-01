<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('organisations.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('organisations.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])
        <div class="form-group">
            {!! Form::select2(
                'organisation_id',
                (isset($model) && $model->organisation ? $model->organisation : $formService->prefillSelect('organisation', $source)),
                App\Models\Organisation::class,
                true,
                'organisations.fields.organisation'
            ) !!}
        </div>

        @include('cruds.fields.location')

        @if ($campaign->enabled('characters'))
            <input type="hidden" name="sync_org_members" value="1">
            <div class="form-group">
                {!! Form::members(
                    'id',
                    [
                        'model' => isset($model) ? $model : $formService->prefillModel($source)
                    ]
                ) !!}
            </div>
        @endif

        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>

@section('scripts')
    @parent
    <script src="{{ mix('js/organisation.js') }}" defer></script>
@endsection