<?php /** @var \App\Renderers\Layouts\Header $head */?>
<a href="{{ $head->route() }}">
    {!! $head->icon() !!}{!! __($head->label()) !!}
</a>
