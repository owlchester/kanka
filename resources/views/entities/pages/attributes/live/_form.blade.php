<?php /* @var \App\Models\Attribute $attribute */?>
<x-forms.field field="name" css="w-full">
    <label for="name">{!! $attribute->name() !!}</label>
    @if ($attribute->isCheckbox())
        <div>
            <input type="hidden" name="value" value="" />
            <input type="checkbox" name="value" id="name" @if($attribute->value) checked="checked" @endif />
        </div>
    @elseif ($attribute->isText())
        <textarea name="value" class="w-full" rows="4">{!! $attribute->value !!}</textarea>
    @elseif ($attribute->isNumber())
        <input type="number" name="value" class="" maxlength="20" value="{{ $attribute->value }}"
               @if ($attribute->validConstraints()) max="{{ $attribute->numberMax() }}" min="{{ $attribute->numberMin() }}" @endif />
    @elseif ($attribute->validConstraints())
        <select name="value" class="">
            @foreach ($attribute->listRange() as $option)
                <option value="{{ $option }}" @if ($option == $attribute->value) selected="selected" @endif>{{ \App\Facades\Mentions::onlyName()->mapText($option) }}</option>
            @endforeach
        </select>
        <x-helper>
            <p>{{ __('entities/attributes.ranges.text', ['options' => $attribute->listRangeText()]) }}</p>
        </x-helper>
    @else
        <input type="text" name="value" class="w-full" maxlength="191" value="{{ $attribute->value }}" />
    @endif
</x-forms.field>
