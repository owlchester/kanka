@if ($radio)
    <div class="flex flex-col gap-2">
    @foreach ($options as $k => $v)
        <div class="flex gap-2 items-center">
            <input type="radio" name="{{ $name }}" id="{{ $fieldId() . '_' . $k }}" @if(isset($disabled) && isset($disabled[$k])) disabled='disabled' @endif value="{{ $k }}" @if ($isSelected($k)) checked="checked" @endif />
            <label for="{{  $fieldId() . '_' . $k }}" class="cursor-pointer">{!! $v !!}</label>
        </div>
    @endforeach
    </div>
@else
<select
    name="{{ $name }}"
    id="{{ $fieldId() }}"
    class="w-full {{ $class }}"
@if ($required) required="required" @endif
@if ($multiple) multiple @endif
@if (!empty($label)) aria-label="{!! $label !!}" @endif
@foreach ($extra as $k => $v)   {{ $k }}="{{ $v }}" @endforeach
@if ($attributes->has('x-model')) x-model="{{ $attributes->get('x-model') }}" @endif
>
@foreach ($options as $k => $v)
    @if (is_array($v))
        <optgroup label="{{ $k }}">
            @foreach ($v as $k2 => $v2)
                <option value="{{ $k2 }}" @if ($isSelected($k2)) selected="selected" @endif>{!! $v2 !!}</option>
            @endforeach
        </optgroup>
    @else
        <option value="{{ $k }}" @if ($isSelected($k)) selected="selected" @endif @foreach ($optionAttributes($k) as $ov => $ok) {{ $ov }}="{{ $ok }}" @endforeach @if(isset($disabled) && isset($disabled[$k])) disabled='disabled' @endif >{!! $v !!}</option>
    @endif
@endforeach
</select>
@endif
