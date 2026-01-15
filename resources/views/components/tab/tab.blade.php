<li role="presentation" class="tab-{{ $target }} flex items-stretch {{ (request()->get('tab') == ($default ? null : 'form-' . $target) ? ' active' : '') }} border-b-2 text-primary-content hover:text-primary transform-all duration-150">
    <a href="#form-{{ $target }}" class="whitespace-nowrap" title="{{ $title }}"  aria-controls="form-{{ $target }}">
        @if ($icon) <x-icon :class="$icon" /> @endif
        {{ $title }}
    </a>
</li>
