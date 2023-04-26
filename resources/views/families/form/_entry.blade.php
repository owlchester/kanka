
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
            <x-forms.foreign
                name="family_id"
                :preset="isset($model) && $model->family ? $model->family : FormCopy::field('family')->select(true, \App\Models\Family::class)"
                allowNew="1"
                entityType="families"
                allowClear="1"
                label="crud.fields.parent"
                :route="route('families.find')"
                :model="$model ?? null"
                :class="\App\Models\Family::class">
            </x-forms.foreign>
        </div>
    </div>
    <div class="col-md-6">
        @include('cruds.fields.location', ['quickCreator' => true])
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

