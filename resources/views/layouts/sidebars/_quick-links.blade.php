@foreach ($links as $bookmark)
        <?php /** @var \App\Models\Bookmark $bookmark */ ?>
    @include('layouts.sidebars._quick-link', ['bookmark' => $bookmark])
@endforeach
