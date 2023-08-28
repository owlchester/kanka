<?php
$nameBlock = '';
$textBlock = 'grow';
$actionBlock = 'flex gap-2';
$flex = 'flex flex-wrap md:flex-no-wrap items-start gap-1';
?>
    <!-- Attribute Section -->
@section('modals')
    @parent
    <div class="attribute-templates hidden">
        <div class="{{ $flex }} attribute_row" id="attribute_template">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <div class="field">
                    <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                    {!! Form::text('attr_name[$TMP_ID$]', null, [
                        'placeholder' => __('entities/attributes.placeholders.attribute'),
                        'class' => 'w-full',
                        'maxlength' => 191
                    ]) !!}
                </div>
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::text('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'w-full kanka-mentions', 'maxlength' => 191, 'data-remote' => route('search.live', $campaign)]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_pinned[$TMP_ID$]', false) !!}
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif

                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>
            {!! Form::hidden('attr_type[$TMP_ID$]', \App\Models\Attribute::TYPE_STANDARD_ID) !!}
        </div>
        <!-- Text Section -->
        <div class="{{ $flex }} attribute_row" id="text_template">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <div class="field">
                    <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                    {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.block'), 'class' => 'w-full', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::textarea('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'w-full kanka-mentions', 'rows' => 3, 'data-remote' => route('search.live', $campaign)]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_pinned[$TMP_ID$]', false) !!}
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete pull-right" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>

            {!! Form::hidden('attr_type[$TMP_ID$]', \App\Models\Attribute::TYPE_TEXT_ID) !!}
        </div>
        <!-- Number Section -->
        <div class="{{ $flex }} attribute_row" id="number_template">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.number'), 'class' => 'w-full', 'maxlength' => 191]) !!}
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::number('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'w-full']) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_pinned[$TMP_ID$]', false) !!}
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete pull-right" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>

            {!! Form::hidden('attr_type[$TMP_ID$]', \App\Models\Attribute::TYPE_NUMBER_ID) !!}
        </div>

        <div class="{{ $flex }} attribute_row items-center" id="checkbox_template">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.checkbox') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.checkbox'), 'class' => 'w-full', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::checkbox('attr_value[$TMP_ID$]', 1, false) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_pinned[$TMP_ID$]', false) !!}
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif

                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>

            {!! Form::hidden('attr_type[$TMP_ID$]', \App\Models\Attribute::TYPE_CHECKBOX_ID) !!}
        </div>
        <!-- Section -->
        <div class="{{ $flex }} attribute_row" id="section_template">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.section') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.section'), 'class' => 'w-full', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::hidden('attr_value[$TMP_ID$]', null) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_pinned[$TMP_ID$]', false) !!}
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>
            {!! Form::hidden('attr_type[$TMP_ID$]', \App\Models\Attribute::TYPE_SECTION_ID) !!}
        </div>
        <!-- Random -->
        <div class="{{ $flex }} attribute_row"  id="random_template">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="field {{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, [
                    'placeholder' => __('entities/attributes.placeholders.random.name'),
                    'class' => 'w-full',
                    'maxlength' => 191
                ]) !!}
            </div>
            <div class="field {{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::text('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.random.value'), 'class' => 'w-full', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_pinned[$TMP_ID$]', false) !!}
                <i class="fa-regular fa-star fa-2x"  data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="{{ __('entities/attributes.visibility.tab') }}"
                   data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
                ></i>

                @if ($isAdmin)
                    {!! Form::hidden('attr_is_private[$TMP_ID$]', false) !!}
                    <i class="fa-solid fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
                       data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
                    ></i>
                @endif
                <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" size="fa-2x" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </a>
            </div>
            {!! Form::hidden('attr_type[$TMP_ID$]', \App\Models\Attribute::TYPE_RANDOM_ID) !!}
        </div>
    </div>
@endsection
