<div class="flex flex-wrap gap-2 items-center">
    <button type="button" class="btn2 btn-sm add_attribute" data-template="#attribute_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
        <x-icon class="plus"></x-icon> {{ __('entities/attributes.types.attribute') }}
    </button>
    <div class="dropdown">
        <button type="button" class="btn2 btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            {{ __('entities/attributes.actions.more') }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="#" class="add_attribute" data-template="#checkbox_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                    <i class="fa-solid fa-check"></i> {{ __('entities/attributes.types.checkbox') }}
                </a>
            </li>
            <li>
                <a href="#" class="add_attribute" data-template="#text_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                    <i class="fa-solid fa-align-justify"></i> {{ __('entities/attributes.types.text') }}
                </a>
            </li>
            <li>
                <a href="#" class="add_attribute" data-template="#number_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                    <i class="fa-solid fa-hashtag"></i> {{ __('entities/attributes.types.number') }}
                </a>
            </li>
            <li>
                <a  href="#" class="add_attribute" data-template="#section_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                    <i class="fa-solid fa-layer-group"></i> {{ __('entities/attributes.types.section') }}
                </a>
            </li>
            @if(request()->is('*/attribute_templates/*') || (isset($entity) && $entity->isAttributeTemplate()))
            <li>
                <a  href="#" class="add_attribute" data-template="#random_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
                    <i class="fa-solid fa-question"></i> {{ __('entities/attributes.types.random') }}
                </a>
            </li>
            @endif
        </ul>
    </div>
    @if (isset($entity) && $entity->attributes()->where('is_hidden', '1')->get()->has('0'))
        <button type="button" class="btn2 btn-ghost" data-toggle="dialog" data-target="hidden-attributes">
            <i class="fa-solid fa-eye-slash" aria-hidden="true"></i>
            {{ __('entities/attributes.actions.show_hidden') }}
        </button>
    @endif

    <div class="grow">
        <a href="//docs.kanka.io/en/latest/features/attributes.html" target="_blank" class="btn2 btn-sm btn-link">
            {{ __('helpers.attributes.link') }}
        </a>
    </div>
    <button type="button" class="btn2 btn-error btn-sm btn-outline" data-toggle="dialog" data-target="attributes-delete-all-confirm">
        <x-icon class="trash"></x-icon>
        {{ __('entities/attributes.actions.remove_all') }}
    </button>
</div>

<x-alert type="warning" class="alert-too-many-fields mt-6" :hidden="true">
    {!! __('entities/attributes.errors.too_many', [
    'max' => number_format(ini_get('max_input_vars'))
    ]) !!}
</x-alert>
<!-- Modal -->



@if (auth()->user()->isAdmin())
    @php
        $role = \App\Facades\CampaignCache::adminRole();
    @endphp
    <hr />
    <div class="field-private">
        {!! Form::hidden('is_attributes_private', 0) !!}
        <label>{!! Form::checkbox('is_attributes_private', 1, empty($model) ? false : $model->entity->is_attributes_private) !!}
            {{ __('entities/attributes.fields.is_private') }}
        </label>
        <p class="help-block">{!! __('entities/attributes.hints.is_private2', [
    'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), $campaign, ['target' => '_blank'])
    ]) !!}</p>
    </div>
@endif

@section('modals')
    @parent
    @if (isset($entity) && $entity->attributes()->where('is_hidden', '1')->get()->has('0'))
        <x-dialog id="hidden-attributes" :title="__('entities/attributes.show.hidden')" :full="true">
            @foreach ($entity->attributes()->ordered()->get() as $attribute)
                @if ($attribute->is_hidden)
                    @include('cruds.forms.attributes._hidden_attribute')
                @endif
            @endforeach
        </x-dialog>
    @endif
    <x-dialog id="attributes-delete-all-confirm" :title="__('crud.delete_modal.title')">
        <p>
            {!! __('entities/attributes.helpers.delete_all') !!}
        </p>
        <div class="grid grid-cols-2 gap-5 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>
            <x-buttons.confirm type="danger" outline="true" full="true" id="attributes-delete-all-confirm-submit">
                <x-icon class="trash"></x-icon>
                {{ __('crud.click_modal.confirm') }}
            </x-buttons.confirm>
            <input type="hidden" name="delete-all-attributes" value="" />
        </div>
    </x-dialog>
@endsection
