@if (isset($onlySave))
    <button class="btn btn-success" id="form-submit-main" data-target="{{ isset($target) ? $target : null }}">
        <span>{{ __('crud.save') }}</span>
        <i class="fa-solid fa-spinner fa-spin spinner" style="display: none"></i>
    </button>
@else
    <div class="form-group mb-0">
        <div class="btn-group">
            <input id="submit-mode" type="hidden" value="true"/>
            <button class="btn btn-success btn-{{ !isset($model) ? 'save' : 'edit' }}-{{ isset($entityType) ? 'entity' : 'other' }}" id="form-submit-main" @if (isset($entityType))data-entity-type="{{ $entityType }}"@endif data-target="{{ isset($target) ? $target : null }}">
                <span>{{ __('crud.save') }}</span>
                <i class="fa-solid fa-spinner fa-spin spinner" style="display: none"></i>
            </button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu {{ isset($disableCancel) ? 'dropdown-menu-right' : '' }}" role="menu">
                <li>
                    <a href="#" class="form-submit-actions flex">
                        <span class="flex-grow">{{ __('crud.save') }}</span>
                        <span class="keyboard-shortcut flex-none" data-toggle="tooltip" title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+S</code>']) !!}" data-html="true">
                            CTRL+S
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="form-submit-actions flex" data-action="submit-new">
                        <span class="flex-grow">{{ __('crud.save_and_new') }}</span>
                        <span class="keyboard-shortcut flex-none ml-2" data-toggle="tooltip" title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+ALT+S</code>']) !!}" data-html="true">
                            CTRL+ALT+S
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="form-submit-actions flex" data-action="submit-update">
                        <span class="flex-grow">{{ __('crud.save_and_update') }}</span>
                        <span class="keyboard-shortcut flex-none ml-2" data-toggle="tooltip" title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+SHIFT+S</code>']) !!}" data-html="true">
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
                        <a href="#" class="form-submit-actions flex" data-action="submit-copy">
                            <span class="flex-grow">{{ __('crud.save_and_copy') }}</span>
                            <span class="keyboard-shortcut flex-none ml-2" data-toggle="tooltip" title="{!! __('crud.keyboard-shortcut', ['code' => '<code>CTRL+ALT+C</code>']) !!}" data-html="true">
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
