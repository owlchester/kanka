
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'families'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Family::class, 'trans' => 'families'])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::foreignSelect(
                'family_id',
                [
                    'preset' => (isset($model) && $model->family ? $model->family : FormCopy::field('family')->select(true, \App\Models\Family::class)),
                    'class' => App\Models\Family::class,
                    'quickCreator' => true,
                    'labelKey' => 'families.fields.family',
                    'from' => isset($model) ? $model : null,
                ]
            ) !!}
        </div>
    </div>
    <div class="col-md-6">
        @include('cruds.fields.location', ['quickCreator' => true])
    </div>
</div>

@include('cruds.fields.entry2')

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

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
@include('cruds.fields.private2')

