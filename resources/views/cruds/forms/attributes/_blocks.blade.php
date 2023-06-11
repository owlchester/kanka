<?php
$nameBlock = '';
$textBlock = 'grow';
$actionBlock = 'flex gap-2';
$flex = 'flex flex-wrap md:flex-no-wrap items-start gap-2 mb-2';

?>
<!-- Attribute Section -->
@section('modals')
    @parent
<div class="attribute-templates hidden">
    <div class="" id="attribute_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <div class="">
                    <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                    {!! Form::text('attr_name[$TMP_ID$]', null, [
                        'placeholder' => __('entities/attributes.placeholders.attribute'),
                        'class' => 'form-control',
                        'maxlength' => 191
                    ]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::text('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'form-control kanka-mentions', 'maxlength' => 191, 'data-remote' => route('search.live')]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
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
    </div>
    <!-- Text Section -->
    <div class="" id="text_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <div class="">
                    <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                    {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.block'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="{{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::textarea('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'form-control kanka-mentions', 'rows' => 3, 'data-remote' => route('search.live')]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
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
    </div>
    <!-- Number Section -->
    <div class="" id="number_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.number'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::number('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.value'), 'class' => 'form-control']) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
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
    </div>
    <div class="" id="checkbox_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.checkbox') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.checkbox'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::checkbox('attr_value[$TMP_ID$]', 1, false) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
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
    </div>
    <!-- Section -->
    <div class="" id="section_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.section') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.section'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $textBlock }}">
                {!! Form::hidden('attr_value[$TMP_ID$]', null) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
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
    </div>
    <!-- Random -->
    <div class="" id="random_template">
        <div class="{{ $flex }} attribute_row">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="{{ $nameBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.name') }}</label>
                {!! Form::text('attr_name[$TMP_ID$]', null, [
                    'placeholder' => __('entities/attributes.placeholders.random.name'),
                    'class' => 'form-control',
                    'maxlength' => 191
                ]) !!}
            </div>
            <div class="{{ $textBlock }}">
                <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
                {!! Form::text('attr_value[$TMP_ID$]', null, ['placeholder' => __('entities/attributes.placeholders.random.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="{{ $actionBlock }}">
                {!! Form::hidden('attr_is_star[$TMP_ID$]', false) !!}
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
</div>
@endsection
