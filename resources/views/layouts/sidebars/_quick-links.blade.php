@foreach ($links as $menuLink)
    <?php /** @var \App\Models\MenuLink $menuLink */ ?>
    @include('layouts.sidebars._quick-link', ['menuLink' => $menuLink])
@endforeach
