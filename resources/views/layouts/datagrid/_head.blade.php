<?php /** @var \App\Renderers\Layouts\Header $head */?>
<a href="#" data-url="{{ $head->route() }}">
    <x-icon :class="$head->icon()" />{!! __($head->label()) !!}
</a>
