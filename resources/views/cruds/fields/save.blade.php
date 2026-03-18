@if (isset($onlySave))
    <button class="btn2 btn-primary" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">
        <span>{{ __('crud.save') }}</span>
        <i class="fa-solid fa-spinner fa-spin spinner" aria-hidden="true" style="display: none"></i>
    </button>
@else
    <input id="submit-mode" type="hidden" value="true"/>
    <div class="join">
        <button class="btn2 join-item btn-primary btn-{{ !isset($model) ? 'save' : 'edit' }}-{{ isset($entityType) ? 'entity' : 'other' }}" id="form-submit-main" @if (isset($entityType))data-entity-type="{{ $entityType }}"@endif data-target="{{ isset($target) ? $target : null }}">
            <span>{{ __('crud.save') }}</span>
            <i class="fa-solid fa-spinner fa-spin spinner" aria-hidden="true" style="display: none"></i>
        </button>
        <div class="dropdown">
            <button type="button" class="btn2 join-item btn-primary" data-dropdown aria-expanded="false">
                <x-icon class="fa-regular fa-caret-down" />
                <span class="sr-only">{{ __('crud.actions.actions') }}</span>
            </button>
            <div class="dropdown-menu hidden" role="menu">
                <x-dropdowns.item link="#" css="form-submit-actions" shortcut="Ctrl S">
                    <span class="grow">{{ __('crud.save') }}</span>
                </x-dropdowns.item>

                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-new']" shortcut="Ctrl Alt S">
                    <span class="grow w-40">{{ __('crud.save_and_new') }}</span>
                </x-dropdowns.item>

                <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-update']" shortcut="Ctrl Shift S">
                    <span class="grow">{{ __('crud.save_and_update') }}</span>
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

                        <x-dropdowns.item link="#" css="form-submit-actions" :data="['action' => 'submit-copy']" shortcut="Ctrl Alt C">
                            <span class="grow">{{ __('crud.save_and_copy') }}</span>
                        </x-dropdowns.item>
                    @endif
                @endif
            </div>
        </div>
        @includeWhen(!isset($disableCancel), 'partials.or_cancel')
    </div>
@endif
