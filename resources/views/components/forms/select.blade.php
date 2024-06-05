<select
    name="{{ $name }}"
    id="{{ $fieldId() }}"
    class="w-full {{ $class }}"
@if ($required) required="required" @endif
@if ($multiple) multiple @endif
@if (!empty($label)) aria-label="{!! $label !!}" @endif
@foreach ($extra as $k => $v)   {{ $k }}="{{ $v }}" @endforeach
>@foreach ($options as $k => $v)
     @if (is_array($v))
         <optgroup label="{{ $k }}">
             @foreach ($v as $k2 => $v2)
                <option value="{{ $k2 }}" @if ($isSelected($k2)) selected="selected" @endif>{!! $v2 !!}</option>
             @endforeach
         </optgroup>
     @else
        <option value="{{ $k }}" @if ($isSelected($k)) selected="selected" @endif @foreach ($optionAttributes($k) as $ov => $ok) {{ $ov }}="{{ $ok }}" @endforeach >{!! $v !!}</option>
    @endif
@endforeach
</select>
