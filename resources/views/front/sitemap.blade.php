<?xml version="1.0" encoding="UTF-8"?>
@if (!empty($urls))
<urlset>
@foreach ($urls as $link)
    <url>
        <loc>{{ $link }}</loc>
    </url>
@endforeach
</urlset>
@endif
@if (!empty($sitemaps))
<sitemapindex>
@foreach ($sitemaps as $link)
    <sitemap>
        <loc>{{ $link }}</loc>
    </sitemap>
@endforeach
</sitemapindex>
@endif