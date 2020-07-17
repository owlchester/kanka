<?php
/**
 * Description of
 *
 * @author Ilestis
 * 21/10/2019
 */

namespace App\Services;

use App\Models\Campaign;
use App\Models\Faq;
use App\Models\Release;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SitemapService
{
    /**
     * @var string
     */
    protected $locale = '';
    protected $page = '';

    /**
     * @param string $locale
     * @return $this
     */
    public function locale(string $locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @param string $page
     * @return $this
     */
    public function page(string $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return array
     */
    public function sitemaps(): array
    {
        if (empty($this->page)) {
            return $this->base();
        }
        elseif (!empty($this->page) && method_exists($this, $this->page)) {
            return [];
        }
    }

    public function urls(): array
    {
        if (empty($this->locale)) {
            return [];
        }

        if (!empty($this->page) && method_exists($this, $this->page)) {
            return $this->{$this->page}();
        }

        return $this->language(true);
    }

    protected function language(bool $urls = false): array
    {
        if ($urls) {
            // Pages
            $links = [];
        } else {

        }

        return $links;
    }

    /**
     * @return array
     */
    protected function campaigns(): array
    {
        $links = [];

        $features = Campaign::public()->front()->featured()->get();
        $campaigns = Campaign::public()->front()->featured(false)->paginate();

        /** @var Campaign $campaign */
        foreach ($features as $campaign) {
            $links[] = LaravelLocalization::localizeURL($campaign->getMiddlewareLink(), $this->locale);
        }
        foreach ($campaigns as $campaign) {
            $links[] = LaravelLocalization::localizeURL($campaign->getMiddlewareLink(), $this->locale);
        }
        return $links;
    }

    /**
     * @return array
     */
    protected function news(): array
    {
        $links = [];
        /** @var Release $release */
        foreach (Release::published()->get() as $release) {
            $links[] = LaravelLocalization::localizeURL(route('front.news.show', $release->getSlug()), $this->locale);
        }
        return $links;
    }

    /**
     * @return array
     */
    protected function index(): array
    {
        $links = [];
        $base = [
            '/',
            'about',
            'privacy-policy',
            'faq',
            'features',
            'pricing',
            'roadmap',
            'community',
            'public-campaigns',
            'news',
        ];

        foreach ($base as $link) {
            $links[] = LaravelLocalization::localizeURL($link, $this->locale);
        }
        return $links;
    }

    protected function base(): array
    {
        $links = [];
        $links[] = route('front.sitemap', ['locale' => $this->locale, 'page' => 'index']);
        $links[] = route('front.sitemap', ['locale' => $this->locale, 'page' => 'news']);
        $links[] = route('front.sitemap', ['locale' => $this->locale, 'page' => 'campaigns']);
        return $links;
    }
}
