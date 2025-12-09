<?php /** @var \App\Renderers\Layouts\Header $head */?>
<a href="#" data-url="{{ $head->route() }}" class="text-link">
    <x-icon :class="$head->icon()" />{!! __($head->label()) !!}
</a>
