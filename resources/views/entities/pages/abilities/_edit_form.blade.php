
<x-grid type="1/1">
    <div class="field-ability">
        <label>{{ __('entities.ability') }}</label><br />
        {!! $ability->ability->tooltipedLink() !!}
        {!! Form::hidden('ability_id', $ability->ability_id) !!}
    </div>

    <div class="field-note">
        <label>
            {{ __('entities/abilities.fields.note') }}
            <div class="hidden md:inline-block">
                <i class="fa-solid fa-question-circle" aria-hidden="true" data-title="{!! __('entities/abilities.helpers.note', [
        'code' => '<code>[character:4096]</code>',
        'attr' => '<code>{Strength}</code>'
    ]) !!}" data-toggle="tooltip" data-html="true" data-placement="left"></i>
            </div>
        </label>
        {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 4]) !!}
        <p class="help-block sm:hidden">{!! __('entities/abilities.helpers.note', [
        'code' => '<code>[character:4096]</code>',
        'attr' => '<code>{Strength}</code>'
    ]) !!}</p>
    </div>

    @include('cruds.fields.visibility_id', ['model' => $ability])
</x-grid>
