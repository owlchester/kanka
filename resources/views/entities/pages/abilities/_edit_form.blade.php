

<div class="form-group">
    <label>{{ __('entities.ability') }}</label><br />
    {!! $ability->ability->tooltipedLink() !!}
    {!! Form::hidden('ability_id', $ability->ability_id) !!}
</div>

<div class="form-group">
    <div class="pull-right hidden-xs">
        <i class="fa-solid fa-question-circle" title="{!! __('entities/abilities.helpers.note', [
    'code' => '<code>[character:4096]</code>',
    'attr' => '<code>{Strengh}</code>'
]) !!}" data-toggle="tooltip" data-html="true" data-placement="left"></i>
    </div>
    <label>{{ __('entities/abilities.fields.note') }}</label>
    {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 4]) !!}
    <p class="help-block hidden-sm hidden-md hidden-lg hidden-xl">{!! __('entities/abilities.helpers.note', [
    'code' => '<code>[character:4096]</code>',
    'attr' => '<code>{Strengh}</code>'
]) !!}</p>
</div>

@include('cruds.fields.visibility_id', ['model' => $ability])
