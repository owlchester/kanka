
    <div class="modal-body">
        @if (request()->ajax())
            <div class="text-center mb-5">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ __('entities/attributes.template.title', ['name' => $entity->name]) }}</h4>
            </div>
        @endif
        {!! Form::open(['route' => ['entities.attributes.template', [$campaign, $entity]], 'method'=>'POST', 'data-shortcut' => '1']) !!}
        {{ csrf_field() }}
        <div class="form-group required">
            <label>{{ __('entities/attributes.fields.template') }}</label>
            {!! Form::select('template_id', $templates, null, ['placeholder' => __('entities/attributes.placeholders.template'), 'class' => 'form-control']) !!}
        </div>

        <p class="help-block">
        {!! __('attributes/templates.pitch', [
    'boosted-campaign' => link_to_route('front.boosters', __('concept.boosted-campaign')),
    'marketplace' => link_to(config('marketplace.url') . '/attribute-templates', __('front.menu.marketplace'), ['target' => '_blank'])
    ]) !!}
        </p>
        <div class="my-5 text-center">
            <button type="button" class="btn btn-default mr-5 rounded-full px-8" data-dismiss="modal">
                {{ __('crud.cancel') }}
            </button>
            @include('entities.pages.attribute-templates._actions')
        </div>
        {!! Form::close() !!}
    </div>
