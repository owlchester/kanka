@if (!$script)<div class="{{ uniqid("ven-ad-") }}">@endif
{!! $slot !!}
@if (!$script)</div>@endif
