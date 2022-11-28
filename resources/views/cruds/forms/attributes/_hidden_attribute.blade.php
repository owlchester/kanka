<div class="form-group">
    <div class="row attribute_row">
        <div class="col-xs-12 col-sm-4">
            <dt>{{ $attribute->name }}</dt>    
        </div>
        <div class="col-xs-7 col-sm-4 col-md-5 col-lg-6">
            @if ($attribute->isCheckbox())
                <i class="@if($attribute->value == 1)fa-solid fa-check-square @else fa-solid fa-square @endif mr-2 fa-2x" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="@if($attribute->is_star) {{ __('entities/attributes.visibility.entry') }} @else  {{ __('entities/attributes.visibility.tab') }} @endif"></i>
            @else
                {{ $attribute->value }}
            @endif
        </div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">
            <i class="fa-star mr-2 @if($attribute->is_star) fa-solid @else fa-regular @endif fa-2x" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="@if($attribute->is_star) {{ __('entities/attributes.visibility.entry') }} @else  {{ __('entities/attributes.visibility.tab') }} @endif"></i>
            @if ($isAdmin)
                <i class="fa-solid @if($attribute->is_private) fa-lock @else fa-unlock-alt @endif fa-2x" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
            @endif
        </div>
    </div>
</div>
