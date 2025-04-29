<div class="submit-group">
    <input id="submit-mode" type="hidden" value="true"/>
    <div class="join">
        <button class="btn2 join-item btn-primary" id="form-submit-main"
    >{{ __('crud.actions.apply') }}</button>

        <div class="dropdown">
            <button type="button" class="btn2 join-item btn-primary" data-dropdown aria-expanded="false">
                <x-icon class="fa-regular fa-caret-down" />
                <span class="sr-only">{{ __('crud.actions.actions') }}</span>
            </button>
            <div class="dropdown-menu hidden" role="menu">
                <x-dropdowns.item link="#" css="form-submit-actions">
                    {{ __('crud.actions.apply') }}
                </x-dropdowns.item>
                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'update']">
                    {{ __('entities/attributes.actions.save_and_edit') }}
                </x-dropdowns.item>
                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'story']">
                    {{ __('entities/attributes.actions.save_and_story') }}
                </x-dropdowns.item>
            </div>
        </div>
    </div>
</div>
