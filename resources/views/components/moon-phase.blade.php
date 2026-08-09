@props(['phase', 'colour' => '#6B7280'])

<svg {{ $attributes->merge(['class' => 'moon-phase inline-block']) }} style="color: {{ $colour }}" viewBox="0 0 24 24" aria-hidden="true">
    @switch($phase)
        @case('full')
        <circle cx="12" cy="12" r="9" fill="currentColor" />
            @break
        @case('new')
            <circle cx="12" cy="12" r="9" fill="currentColor" opacity="0.2" />
            @break
        @case('first_quarter')
            <circle cx="12" cy="12" r="9" fill="currentColor" opacity=".2" />
            <path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" />
            @break
        @case('last_quarter')
            <circle cx="12" cy="12" r="9" fill="currentColor" opacity=".2" />
            <path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" />
            @break
        @case('waxing_crescent')
            <circle cx="12" cy="12" r="9" fill="currentColor" opacity=".2" />
            <path d="M12 3a9 9 0 0 1 0 18A7 9 0 0 0 12 3z" fill="currentColor" />
            @break
        @case('waning_crescent')
            <circle cx="12" cy="12" r="9" fill="currentColor" opacity=".2" />
            <path d="M12 3a9 9 0 0 0 0 18A7 9 0 0 1 12 3z" fill="currentColor" />
            @break
        @case('waxing_gibbous')
            <circle cx="12" cy="12" r="9" fill="currentColor" opacity=".2" />
            <path d="M12 3a9 9 0 0 1 0 18A5 9 0 0 1 12 3z" fill="currentColor" />
            @break
        @case('waning_gibbous')
            <circle cx="12" cy="12" r="9" fill="currentColor" opacity=".2" />
            <path d="M12 3a9 9 0 0 0 0 18A5 9 0 0 0 12 3z" fill="currentColor" />
            @break
    @endswitch
</svg>
