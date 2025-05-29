<div class="submit-group">
    <input id="submit-mode" type="hidden" value="true"/>
    <div class="join">
        <button class="btn2 join-item btn-primary" id="form-submit-main"
            data-action="{{ request()->from == 'explore' ? 'submit-explore' : null }}"
            data-target="{{ isset($target) ? $target : null }}">{{ __('crud.save') }}
        </button>
        <div class="dropup">
            <button type="button" class="btn2 join-item btn-primary " data-dropdown
                aria-expanded="false">
                <x-icon class="fa-regular fa-caret-down" />
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
</div>
