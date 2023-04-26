
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
        @include('cruds.fields.family', ['isParent' => true])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.location')
    </div>
</div>

@include('cruds.fields.entry2')

@if ($campaignService->enabled('characters'))
    <input type="hidden" name="sync_family_members" value="1">
    <div class="form-group">
        @include('components.form.family_members', ['options' => [
            'model' => $model ?? FormCopy::model(),
            'source' => $source ?? null,
        ]])
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

