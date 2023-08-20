<x-grid type="1/1">
    <div class="field-template required">
        <label>{{ __('entities/attributes.fields.template') }}</label>
        {!! Form::select('template_id', $templates, null, ['placeholder' => __('entities/attributes.placeholders.template'), 'class' => 'form-control', 'required']) !!}
    </div>

    <p class="help-block">
        {!! __('attributes/templates.pitch', [
    'boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaigns')),
    'marketplace' => link_to(config('marketplace.url') . '/attribute-templates', __('footer.marketplace'), ['target' => '_blank'])
    ]) !!}
    </p>
</x-grid>
