<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'organisations'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            @include('cruds.fields.organisation', ['isParent' => true])
        </div>
    </div>
    <div class="col-md-6">
        @include('cruds.fields.location')
    </div>
</div>

@include('cruds.fields.entry2')

@if ($campaignService->enabled('characters'))
    <div class="form-group">
        @include('components.form.members', ['options' => [
            'model' => $model ?? FormCopy::model(),
            'source' => $source ?? null
        ]])
    </div>
    <input type="hidden" name="sync_org_members" value="1">
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::hidden('is_defunct', 0) !!}
            <label>{!! Form::checkbox('is_defunct', 1, $model->is_defunct ?? '' )!!}
                {{ __('organisations.fields.is_defunct') }}
            </label>
            <p class="help-block">{{ __('organisations.hints.is_defunct') }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
