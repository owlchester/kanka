<div class="form-group">
    <label>{{ trans('characters.fields.title') }}</label>
    {!! Form::text('title', FormCopy::field('title')->string(), ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
@include('cruds.fields.family')
@include('cruds.fields.race')
@include('cruds.fields.location')

@include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

{!! Form::hidden('is_personality_visible', CampaignLocalization::getCampaign()->entity_personality_visibility ? 0 : 1) !!}