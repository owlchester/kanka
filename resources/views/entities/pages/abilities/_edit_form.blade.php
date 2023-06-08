

<div class="field-ability mb-5">
    <label>{{ __('entities.ability') }}</label><br />
    {!! $ability->ability->tooltipedLink() !!}
    {!! Form::hidden('ability_id', $ability->ability_id) !!}
</div>

<div class="field-note mb-5">
    <div class="pull-right hidden-xs">
        <i class="fa-solid fa-question-circle" aria-hidden="true" title="{!! __('entities/abilities.helpers.note', [
    'code' => '<code>[character:4096]</code>',
    'attr' => '<code>{Strength}</code>'
]) !!}" data-toggle="tooltip" data-html="true" data-placement="left"></i>
    </div>
    <label>{{ __('entities/abilities.fields.note') }}</label>
    {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 4]) !!}
    <p class="help-block hidden-sm hidden-md hidden-lg hidden-xl">{!! __('entities/abilities.helpers.note', [
    'code' => '<code>[character:4096]</code>',
    'attr' => '<code>{Strength}</code>'
]) !!}</p>
</div>

@include('cruds.fields.visibility_id', ['model' => $ability])
