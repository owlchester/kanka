<li role="presentation" class="tab-lifted tab-{{ $target }} flex items-stretch {{ (request()->get('tab') == ($default ? null : 'form-' . $target) ? ' active' : '') }}">
    <a href="#form-{{ $target }}" class="whitespace-nowrap" title="{{ $title }}"  aria-controls="form-{{ $target }}">
        @if ($icon) <x-icon :class="$icon" /> @endif
        {{ $title }}
    </a>
</li>
