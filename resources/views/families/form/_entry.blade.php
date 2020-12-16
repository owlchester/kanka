
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'families'])
        @include('cruds.fields.type', ['base' => \App\Models\Family::class, 'trans' => 'families'])
        <div class="form-group">
            {!! Form::select2(
                'family_id',
                (isset($model) && $model->family ? $model->family : FormCopy::field('family')->select(true, \App\Models\Family::class)),
                App\Models\Family::class,
                true,
                'families.fields.family'
            ) !!}
        </div>
        @include('cruds.fields.location')

        @if ($campaign->enabled('characters'))
            <input type="hidden" name="sync_family_members" value="1">
            <div class="form-group">
                {!! Form::familyMembers(
                    'id',
                    [
                        'model' => isset($model) ? $model : FormCopy::model(),
                        'source' => $source
                    ]
                ) !!}
            </div>
        @endif

        @include('cruds.fields.tags')

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
