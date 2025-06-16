@foreach ($links as $bookmark)
        <?php /** @var \App\Models\Bookmark $bookmark */ ?>
    @include('layouts.sidebars.bookmark', ['bookmark' => $bookmark])
@endforeach
