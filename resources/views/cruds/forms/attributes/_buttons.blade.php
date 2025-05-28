<div class="flex flex-wrap gap-2 items-center">
    <button type="button" class="btn2 btn-sm" data-attribute-template="#attribute_template" data-sortable="{{ $existing ? 'true' : 'false'}}">
        <x-icon class="plus" /> {{ __('entities/attributes.types.attribute') }}
    </button>
    <div class="dropdown">
        <button type="button" class="btn2 btn-sm" data-dropdown aria-expanded="true">
            <x-icon class="fa-solid fa-caret-down" />
            {{ __('entities/attributes.actions.more') }}
        </button>
        <div class="dropdown-menu hidden" role="menu">
            <x-dropdowns.item link="#" :data="['attribute-template' => '#checkbox_template', 'sortable' => $existing ? 'true' : 'false']" icon="check">
                {{ __('entities/attributes.types.checkbox') }}
            </x-dropdowns.item>

            <x-dropdowns.item link="#" :data="['attribute-template' => '#text_template', 'sortable' => $existing ? 'true' : 'false']" icon="fa-solid fa-align-justify">
                {{ __('entities/attributes.types.text') }}
            </x-dropdowns.item>

            <x-dropdowns.item link="#" :data="['attribute-template' => '#number_template', 'sortable' => $existing ? 'true' : 'false']" icon="fa-solid fa-hashtag">
                {{ __('entities/attributes.types.number') }}
            </x-dropdowns.item>

            <x-dropdowns.item link="#" :data="['attribute-template' => '#section_template', 'sortable' => $existing ? 'true' : 'false']" icon="fa-solid fa-layer-group">
                {{ __('entities/attributes.types.section') }}
            </x-dropdowns.item>

            @if(request()->is('*/attribute_templates/*') || (isset($entity) && $entity->isAttributeTemplate()))
                <x-dropdowns.item link="#" :data="['attribute-template' => '#random_template', 'sortable' => $existing ? 'true' : 'false']" icon="question">
                    {{ __('entities/attributes.types.random') }}
                </x-dropdowns.item>
            @endif
        </div>
    </div>
    @if (isset($entity) && $entity->attributes()->where('is_hidden', '1')->get()->has('0'))
        <button type="button" class="btn2 btn-ghost" data-toggle="dialog" data-target="hidden-attributes">
            <x-icon class="fa-solid fa-eye-slash" />
            {{ __('entities/attributes.actions.show_hidden') }}
        </button>
    @endif

    <div class="grow">
        <a href="//docs.kanka.io/en/latest/features/attributes.html" target="_blank" class="btn2 btn-sm btn-link">
            {{ __('helpers.attributes.link') }}
        </a>
    </div>
    <button type="button" class="btn2 btn-error btn-sm btn-outline" data-toggle="dialog" data-target="attributes-delete-all-confirm">
        <x-icon class="trash" />
        {{ __('entities/attributes.actions.remove_all') }}
    </button>
</div>
<!-- Modal -->



@if (auth()->user()->isAdmin())
    @php
        $role = \App\Facades\CampaignCache::adminRole();
    @endphp
    <hr />
    <x-forms.field field="attributes-private"
                   :label="__('entities/attributes.fields.is_private')">
        <input type="hidden" name="is_attributes_private" value="0" />
        <x-checkbox :text="__('entities/attributes.helpers.is_private', [
    'admin-role' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\' target=\'_blank\'>' . \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')) . '</a>',
    ])">
            <input type="checkbox" name="is_attributes_private" value="1" @if (old('is_attributes_private', $model->entity->is_attributes_private ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
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
                <x-icon class="trash" />
                {{ __('crud.actions.confirm') }}
            </x-buttons.confirm>
            <input type="hidden" name="delete-all-attributes" value="" />
        </div>
    </x-dialog>
@endsection
