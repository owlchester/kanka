
<input id="submit-mode" type="hidden" value="true"/>
<div class="join float-right">
    <button class="btn2 btn-primary join-item btn-xm" id="form-submit-main" data-target="{{ $target ?? null }}">
        {{ __('crud.save') }}
    </button>
    <div class="dropdown">
        <button type="button" class="btn2 btn-primary join-item" data-dropdown aria-expanded="false">
            <x-icon class="fa-solid fa-caret-down" />
            <span class="sr-only">{{ __('crud.actions.actions') }}</span>
        </button>
        <div class="dropdown-menu hidden" role="menu">
            <x-dropdowns.item
                link="#"
                css="form-submit-actions">
                {{ __('crud.save') }}
            </x-dropdowns.item>
            <x-dropdowns.item
                link="#"
                css="form-submit-actions"
                :data="['action' => 'submit-new']">
                {{ __('crud.save_and_new') }}
            </x-dropdowns.item>
            <x-dropdowns.item
                link="#"
                css="form-submit-actions"
                :data="['action' => 'submit-update']">
                {{ __('crud.save_and_update') }}
            </x-dropdowns.item>
            <x-dropdowns.item
                link="#"
                css="form-submit-actions"
                :data="['action' => 'submit-explore']">
                {{ __('maps/markers.actions.save_and_explore') }}
            </x-dropdowns.item>
        </div>
    </div>
</div>
