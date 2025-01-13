<?php
/**
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\Entity $entity
 */
$isAdmin = auth()->user()->isAdmin();
?>
@extends('layouts.app', [
    'title' => __('entities/attributes.index.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.tabs.attributes'),
    ],
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <x-form
        :action="['entities.attributes.save', $campaign, $entity]"
        :extra="['data-max-fields' => ini_get('max_input_vars'),]"
        unload
        class="entity-form flex flex-col gap-5"
    >
        @if(request()->has('old'))
        <x-box>
            <div id="entity-attributes-all">
                <div class="entity-attributes sortable-elements"  data-handle=".sortable-handler" id="add_attribute_target">
                    @foreach ($r = $entity->attributes()->ordered()->get() as $attribute)
                        @if (!$attribute->is_hidden)
                            @include('cruds.forms.attributes._attribute')
                        @endif
                    @endforeach
                </div>
            </div>

            @include('cruds.forms.attributes._blocks', ['existing' => $r->count()])
            @include('cruds.forms.attributes._buttons', ['entity' => $entity, 'existing' => $r->count()])

            <div class="flex gap-2 items-center">
                <a href="{{ url()->previous() }}" class="btn2 btn-ghost">
                    {{ __('crud.cancel') }}
                </a>
                <div class="grow text-right">
                    <button class="btn2 btn-primary">
                        {{ __('crud.save') }}
                    </button>
                </div>
            </div>

        </x-box>
        @endif

        <x-box :padding="false">
            <div id="attributes-manager">
                <attributes-manager api="{{ route('attributes.api-entity', [$campaign, $entity]) }}" />
            </div>

            @if (auth()->user()->isAdmin() && $entity->is_attributes_private)
                @php
                    $role = \App\Facades\CampaignCache::adminRole();
                @endphp
                <div class="m-5 flex flex-col gap-2">
                    <hr />
                    <x-forms.field field="attributes-private"
                                   :label="__('entities/attributes.fields.is_private')">
                        <input type="hidden" name="is_attributes_private" value="0" />
                        <x-checkbox :text="__('entities/attributes.helpers.is_private', [
    'admin-role' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\' target=\'_blank\'>' . \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')) . '</a>',
    ])">
                            <input type="checkbox" name="is_attributes_private" value="1" @if (old('is_attributes_private', $entity->is_attributes_private ?? false)) checked="checked" @endif />
                        </x-checkbox>
                    </x-forms.field>

                <x-alert type="warning">
                    <p>This feature is deprecated. By unchecking it, you will no longer be able to activate it. You can now toggle the private status of all attributes of the entity at once instead.</p>
                </x-alert>
            </div>
            @endif

            <div class="flex gap-2 items-center p-4">
                <a href="{{ url()->previous() }}" class="btn2 btn-ghost">
                    {{ __('crud.cancel') }}
                </a>
                <div class="grow text-right">
                    <button class="btn2 btn-primary">
                        {{ __('crud.save') }}
                    </button>
                </div>
            </div>
        </x-box>
    </x-form>
@endsection
@section('scripts')
    @vite('resources/js/attributes.js')
    @vite('resources/js/attributes-manager.js')
@endsection
