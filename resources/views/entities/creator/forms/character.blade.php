
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label>{{ trans('characters.fields.title') }}</label>
            {!! Form::text('title', FormCopy::field('title')->string(), ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
    </div>
    <div class="col-lg-6">
        @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        @include('cruds.fields.family')
    </div>
    <div class="col-lg-6">
        @include('cruds.fields.races')
    </div>
    <div class="col-lg-6">
        @include('cruds.fields.location')
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        @include('cruds.fields.sex', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
    </div>
    <div class="col-lg-6">
        @include('cruds.fields.age', ['trans' => 'characters'])
    </div>
</div>



{!! Form::hidden('is_personality_visible', CampaignLocalization::getCampaign()->entity_personality_visibility ? 0 : 1) !!}
