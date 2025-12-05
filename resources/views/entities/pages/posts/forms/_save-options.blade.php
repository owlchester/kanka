<div class="join">
    <input id="submit-mode" type="hidden" value="true"/>
    <button class="btn2 btn-sm btn-primary join-item" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">{{ __('crud.save') }}</button>
    <div class="dropdown">
        <button type="button" class="btn2 btn-sm btn-primary join-item" data-dropdown aria-expanded="false">
            <x-icon class="fa-regular fa-caret-down" />
            <span class="sr-only">{{ __('crud.actions.actions') }}</span>
        </button>
        <div class="dropdown-menu hidden" role="menu">
            <x-dropdowns.item link="#" css="form-submit-actions">
                <span class="grow w-40">{{ __('crud.save') }}</span>
                <span class="keyboard-shortcut flex-none ml-2 hidden sm:inline">CTRL+S</span>
            </x-dropdowns.item>
            <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-new']">
                {{ __('crud.save_and_new') }}
            </x-dropdowns.item>
            <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-update']">
                <span class="grow w-40">{{ __('crud.save_and_update') }}</span>
                <span class="keyboard-shortcut flex-none ml-2 hidden sm:inline">CTRL+SHIFT+S</span>
            </x-dropdowns.item>
        </div>
    </div>
</div>

