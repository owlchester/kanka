
<div class="modal-body">
    @if (request()->ajax())
        <div class="text-center mb-5">
            <x-dialog.close />
            <h4 class="modal-title">{{ __('entities/attributes.template.title', ['name' => $entity->name]) }}</h4>
        </div>
    @endif
    {!! Form::open(['route' => ['entities.attributes.template', $entity->id], 'method'=>'POST', 'data-shortcut' => '1']) !!}
    {{ csrf_field() }}
    <div class="field-template required">
        <label>{{ __('entities/attributes.fields.template') }}</label>
        {!! Form::select('template_id', $templates, null, ['placeholder' => __('entities/attributes.placeholders.template'), 'class' => 'form-control']) !!}
    </div>

    <p class="help-block">
    {!! __('attributes/templates.pitch', [
'boosted-campaign' => link_to_route('front.premium', __('concept.premium-campaigns')),
'marketplace' => link_to(config('marketplace.url') . '/attribute-templates', __('front.menu.marketplace'), ['target' => '_blank'])
]) !!}
    </p>
    <x-dialog.footer>

        @include('entities.pages.attribute-templates._actions')
    </x-dialog.footer>
    {!! Form::close() !!}
</div>
