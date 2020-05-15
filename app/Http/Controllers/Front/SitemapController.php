<?php
/**
 * Description of
 *
 * @author Ilestis
 * 21/10/2019
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\SitemapService;

class SitemapController extends Controller
{
    /**
     * @var SitemapService
     */
    public $sitemapService;

    /**
     * SitemapController constructor.
     * @param SitemapService $sitemapService
     */
    public function __construct(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(string $locale)
    {
        $this->sitemapService
            ->locale($locale)
            ->page(request()->get('page', ''));

        $sitemaps = $this->sitemapService->sitemaps();
        $urls = $this->sitemapService->urls();

        $contents = view('front.sitemap', compact('urls', 'sitemaps'));
        return response($contents)->withHeaders([
            'Content-Type' => 'text/xml'
        ]);
    }

    public function language(string $locale)
    {
        $this->sitemapService
            ->locale($locale)
            ->page(request()->get('page', ''));

        $sitemaps = $this->sitemapService->sitemaps();
        $urls = $this->sitemapService->urls();

        $contents = view('front.sitemap', compact('urls', 'sitemaps'));
        return response($contents)->withHeaders([
            'Content-Type' => 'text/xml'
        ]);
    }
}
