<x-grid>
    <div class="form-group">
        <label>{{ __('characters.fields.title') }}</label>
        {!! Form::text('title', FormCopy::field('title')->string(), ['placeholder' => __('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>

    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.families')

    @include('cruds.fields.races')

    @include('cruds.fields.location')

    @include('cruds.fields.sex', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.age', ['trans' => 'characters'])
</x-grid>



{!! Form::hidden('is_personality_visible', CampaignLocalization::getCampaign()->entity_personality_visibility ? 0 : 1) !!}
