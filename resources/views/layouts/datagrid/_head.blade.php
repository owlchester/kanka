<?php /** @var \App\Renderers\Layouts\Header $head */
use Illuminate\Support\Str;
?>
<a href="#" data-url="{{ $head->route() }}" class="text-link">
    <x-icon :class="$head->icon()" />{!! $head->label() !!}
</a>
