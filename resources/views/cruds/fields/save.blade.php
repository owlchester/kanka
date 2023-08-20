@if (isset($onlySave))
    <button class="btn2 btn-primary" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">
        <span>{{ __('crud.save') }}</span>
        <i class="fa-solid fa-spinner fa-spin spinner" aria-hidden="true" style="display: none"></i>
    </button>
@else
    <div class="join">
        <input id="submit-mode" type="hidden" value="true"/>
        <button class="btn2 join-item btn-primary btn-sm btn-{{ !isset($model) ? 'save' : 'edit' }}-{{ isset($entityType) ? 'entity' : 'other' }}" id="form-submit-main" @if (isset($entityType))data-entity-type="{{ $entityType }}"@endif data-target="{{ isset($target) ? $target : null }}">
            <span>{{ __('crud.save') }}</span>
            <i class="fa-solid fa-spinner fa-spin spinner" aria-hidden="true" style="display: none"></i>
        </button>
        <div class="dropdown">
            <button type="button" class="btn2 btn-sm join-item btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu {{ isset($disableCancel) ? 'dropdown-menu-right' : '' }}" role="menu">
                <li>
                    <a href="#" class="form-submit-actions !flex gap-2">
                        <span class="grow">{{ __('crud.save') }}</span>
                        <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+S</code>']) !!}" data-html="true">
                            CTRL+S
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="form-submit-actions !flex gap-2" data-action="submit-new">
                        <span class="grow">{{ __('crud.save_and_new') }}</span>
                        <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+ALT+S</code>']) !!}" data-html="true">
                            CTRL+ALT+S
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="form-submit-actions !flex gap-2" data-action="submit-update">
                        <span class="grow">{{ __('crud.save_and_update') }}</span>
                        <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+SHIFT+S</code>']) !!}" data-html="true">
                            CTRL+SHIFT+S
                        </span>
                    </a>
                </li>
                @if(!isset($disableCopy))
                    @if (empty($model))
                    <li><a href="#" class="form-submit-actions" data-action="submit-view">{{ __('crud.save_and_view') }}</a></li>
                    @else
                    <li><a href="#" class="form-submit-actions" data-action="submit-close">{{ __('crud.save_and_close') }}</a></li>
                    <li>
                        <a href="#" class="form-submit-actions !flex gap-2" data-action="submit-copy">
                            <span class="grow">{{ __('crud.save_and_copy') }}</span>
                            <span class="keyboard-shortcut" data-toggle="tooltip" data-title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+ALT+C</code>']) !!}" data-html="true">
                                CTRL+ALT+C
                            </span>
                        </a>
                    </li>
                    @endif
                @endif
            </ul>
        </div>
        @includeWhen(!isset($disableCancel), 'partials.or_cancel')
    </div>
@endif
