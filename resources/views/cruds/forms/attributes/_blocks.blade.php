<?php
$nameBlock = '';
$textBlock = 'grow';
$actionBlock = 'flex gap-3';
$flex = 'flex flex-wrap md:flex-no-wrap items-start gap-1';
?>
@section('modals')
    @parent
    <template id="attribute_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <div class="field">
                    <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                    <input type="text" name="attr_name[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.attribute') }}" class="w-full" maxlength="191" />
                </div>
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                <input type="text" name="attr_value[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.value') }}" class="w-full kanka-mentions" maxlength="191" data-remote="{{ route('search.live', $campaign) }}" />
            </div>
            <div class="{{ $actionBlock }}">
                <input type="hidden" name="attr_is_pinned[$TMP_ID$]" value="0" />
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    <input type="hidden" name="attr_is_private[$TMP_ID$]" value="0" />
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif

                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>
            <input type="hidden" name="attr_type[$TMP_ID$]" value="{{ \App\Enums\AttributeType::Standard->value }}" />
        </div>
    </template>
    <template id="text_template">
        <div class="{{ $flex }} attribute_row" >
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <div class="field">
                    <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                    <input type="text" name="attr_name[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.attribute') }}" class="w-full" maxlength="191" />
                </div>
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                <textarea name="attr_value[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.value') }}" class="w-full" rows="3" data-remote="{{ route('search.live', $campaign) }}"></textarea>
            </div>
            <div class="{{ $actionBlock }}">
                <input type="hidden" name="attr_is_pinned[$TMP_ID$]" value="0" />
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    <input type="hidden" name="attr_is_private[$TMP_ID$]" value="0" />
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>

            <input type="hidden" name="attr_type[$TMP_ID$]" value="{{ \App\Enums\AttributeType::Block->value }}" />
        </div>
    </template>

    <template id="number_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                <input type="text" name="attr_name[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.number') }}" class="w-full" maxlength="191" />
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                <input type="number" name="attr_value[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.value') }}" class="w-full kanka-mentions" maxlength="191"  />
            </div>
            <div class="{{ $actionBlock }}">
                <input type="hidden" name="attr_is_pinned[$TMP_ID$]" value="0" />
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    <input type="hidden" name="attr_is_private[$TMP_ID$]" value="0" />
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>

            <input type="hidden" name="attr_type[$TMP_ID$]" value="{{ \App\Enums\AttributeType::Number->value }}" />
        </div>
    </template>
    <template id="checkbox_template">
        <div class="{{ $flex }} attribute_row items-center">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.checkbox') }}</label>
                <input type="text" name="attr_name[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.checkbox') }}" class="w-full" maxlength="191" />
            </div>
            <div class="{{ $textBlock }}">
                <input type="checkbox" name="attr_value[$TMP_ID$]" value="1" />
            </div>
            <div class="{{ $actionBlock }}">
                <input type="hidden" name="attr_is_pinned[$TMP_ID$]" value="0" />
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    <input type="hidden" name="attr_is_private[$TMP_ID$]" value="0" />
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif

                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>

            <input type="hidden" name="attr_type[$TMP_ID$]" value="{{ \App\Enums\AttributeType::Checkbox->value }}" />
        </div>
    </template>

    <template id="section_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.section') }}</label>
                <input type="text" name="attr_name[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.section') }}" class="w-full" maxlength="191" />
            </div>
            <input type="hidden" name="attr_value[$TMP_ID$]" value="" />
            <div class="{{ $actionBlock }}">
                <input type="hidden" name="attr_is_pinned[$TMP_ID$]" value="0" />
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    <input type="hidden" name="attr_is_private[$TMP_ID$]" value="0" />
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>
            <input type="hidden" name="attr_type[$TMP_ID$]" value="{{ \App\Enums\AttributeType::Section->value }}" />
        </div>
    </template>

    <template id="random_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                <input type="text" name="attr_name[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.random.name') }}" class="w-full" maxlength="191" />
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                <input type="number" name="attr_value[$TMP_ID$]" placeholder="{{ __('entities/attributes.placeholders.random.value') }}" class="w-full" maxlength="191"  />
            </div>
            <div class="{{ $actionBlock }}">
                <input type="hidden" name="attr_is_pinned[$TMP_ID$]" value="0" />
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    <input type="hidden" name="attr_is_private[$TMP_ID$]" value="0" />
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>
            <input type="hidden" name="attr_type[$TMP_ID$]" value="{{ \App\Enums\AttributeType::Random->value }}" />
        </div>
    </template>
@endsection
