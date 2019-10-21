<?php
/**
 * Description of
 *
 * @author Jeremy Payne it@watson.ch
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
    public function index()
    {
        $links = $this->sitemapService
            ->locale(request()->get('locale', ''))
            ->page(request()->get('page', ''))
            ->links();

        $contents = view('front.sitemap', compact('links'));
        return response($contents)->withHeaders([
            'Content-Type' => 'text/xml'
        ]);
    }
}
