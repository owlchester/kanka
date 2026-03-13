<input id="submit-mode" type="hidden" value="true"/>
<div class="flex gap-2 items-center">
    @if(!empty($model) && $model->exists)
        <x-button.delete-confirm target="#delete-post-form" />
    @endif
    <div class="join">
        <button class="btn2 btn-primary join-item" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">
            <x-icon class="save"></x-icon>
            <span class="hidden md:inline">{{ __('crud.save') }}</span>
        </button>
        <div class="dropdown">
            <button type="button" class="btn2 btn-primary join-item" data-dropdown aria-expanded="false">
                <x-icon class="fa-regular fa-caret-down" />
                <span class="sr-only">{{ __('crud.actions.actions') }}</span>
            </button>
            <div class="dropdown-menu hidden" role="menu">
                <x-dropdowns.item link="#" css="form-submit-actions" shortcut="Ctrl S">
                    {{ __('crud.save') }}
                </x-dropdowns.item>
                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-new']" shortcut="Ctrl Alt S">
                    {{ __('crud.save_and_new') }}
                </x-dropdowns.item>
                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-update']" shortcut="Ctrl Shift S">
                    {{ __('crud.save_and_update') }}
                </x-dropdowns.item>
            </div>
        </div>
    </div>
</div>

