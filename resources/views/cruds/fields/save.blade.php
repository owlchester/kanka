@if (isset($onlySave))
    <button class="btn2 btn-primary" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">
        <span>{{ __('crud.save') }}</span>
        <i class="fa-solid fa-spinner fa-spin spinner" aria-hidden="true" style="display: none"></i>
    </button>
@else
    <input id="submit-mode" type="hidden" value="true"/>
    <div class="join">
        <button class="btn2 join-item btn-primary btn-sm btn-{{ !isset($model) ? 'save' : 'edit' }}-{{ isset($entityType) ? 'entity' : 'other' }}" id="form-submit-main" @if (isset($entityType))data-entity-type="{{ $entityType }}"@endif data-target="{{ isset($target) ? $target : null }}">
            <span>{{ __('crud.save') }}</span>
            <i class="fa-solid fa-spinner fa-spin spinner" aria-hidden="true" style="display: none"></i>
        </button>
        <div class="dropdown">
            <button type="button" class="btn2 btn-sm join-item btn-primary" data-dropdown aria-expanded="false">
                <x-icon class="fa-regular fa-caret-down" />
                <span class="sr-only">{{ __('crud.actions.actions') }}</span>
            </button>
            <div class="dropdown-menu hidden" role="menu">
                <x-dropdowns.item link="#" css="form-submit-actions">
                    <span class="grow">{{ __('crud.save') }}</span>
                    <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+S</code>']) !!}" data-html="true">
                            CTRL+S
                        </span>
                </x-dropdowns.item>

                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-new']">
                    <span class="grow w-40">{{ __('crud.save_and_new') }}</span>
                    <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+ALT+S</code>']) !!}" data-html="true">
                        CTRL+ALT+S
                    </span>
                </x-dropdowns.item>

                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-update']">
                        <span class="grow">{{ __('crud.save_and_update') }}</span>
                        <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+SHIFT+S</code>']) !!}" data-html="true">
                            CTRL+SHIFT+S
                        </span>
                </x-dropdowns.item>
                @if(!isset($disableCopy))
                    @if (empty($model))
                        <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-view']">
                            {{ __('crud.save_and_view') }}
                        </x-dropdowns.item>
                    @else
                        <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-close']">
                            {{ __('crud.save_and_close') }}
                        </x-dropdowns.item>

                        <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-copy']">
                            <span class="grow">{{ __('crud.save_and_copy') }}</span>
                            <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+ALT+C</code>']) !!}" data-html="true">
                                CTRL+ALT+C
                            </span>
                        </x-dropdowns.item>
                    @endif
                @endif
            </div>
        </div>
        @includeWhen(!isset($disableCancel), 'partials.or_cancel')
    </div>
@endif
