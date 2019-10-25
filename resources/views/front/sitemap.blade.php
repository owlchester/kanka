<?xml version="1.0" encoding="UTF-8"?>
@if (!empty($urls))
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $link)
    <url>
        <loc>{{ $link }}</loc>
    </url>
@endforeach
</urlset>
@endif
@if (!empty($sitemaps))
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($sitemaps as $link)
    <sitemap>
        <loc>{{ $link }}</loc>
    </sitemap>
@endforeach
</sitemapindex>
@endif