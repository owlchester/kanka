<?php /** @var \App\Renderers\Layouts\Header $head */?>
<a href="#" data-url="{{ $head->route() }}">
    {!! $head->icon() !!}{!! __($head->label()) !!}
</a>
