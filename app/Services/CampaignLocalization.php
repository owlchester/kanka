<?php

namespace App\Services;

use App\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampaignLocalization
{
    /**
     * Config repository.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $configRepository;

    /**
     * Illuminate view Factory.
     *
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * Illuminate translator class.
     *
     * @var \Illuminate\Translation\Translator
     */
    protected $translator;

    /**
     * Illuminate router class.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Illuminate request class.
     *
     * @var \Illuminate\Routing\Request
     */
    protected $request;

    /**
     * Illuminate url class.
     *
     * @var \Illuminate\Routing\UrlGenerator
     */
    protected $url;

    /**
     * Illuminate request class.
     *
     * @var Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Illuminate request class.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Default locale.
     *
     * @var string
     */
    protected $defaultLocale;

    /**
     * Supported Locales.
     *
     * @var array
     */
    protected $supportedLocales;

    /**
     * Current campaign id.
     *
     * @var string
     */
    protected $campaignId = false;

    protected $campaign = false;

    /**
     * An array that contains all routes that should be translated.
     *
     * @var array
     */
    protected $translatedRoutes = [];

    /**
     * Name of the translation key of the current route, it is used for url translations.
     *
     * @var string
     */
    protected $routeName;

    /**
     * Creates new instance.
     *
     * @throws UnsupportedLocaleException
     */
    public function __construct()
    {
        $this->app = app();

        $this->configRepository = $this->app['config'];
        $this->view = $this->app['view'];
        $this->translator = $this->app['translator'];
        $this->router = $this->app['router'];
        $this->request = $this->app['request'];
        $this->url = $this->app['url'];
    }

    /**
     * Set and return current locale.
     *
     * @param string $locale Locale to set the App to (optional)
     *
     * @return string Returns locale (if route has any) or null (if route does not have a locale)
     */
    public function setCampaign($campaignId = null)
    {
        if (empty($campaignId) || !is_string($campaignId)) {
            // If the locale has not been passed through the function
            // it tries to get it from the first segment of the url
            $segment = $this->request->segment(2);
            $segments = explode('-', $segment);

            if (count($segments) != 2 || empty($segments[1]) || !is_numeric($segments[1])) {
                // Use session?
            } else {
                $campaignId = $segments[1];
            }
        }

        if (!empty($campaignId)) {
            $this->campaignId = $campaignId;
        } else {
            // There is no session at this point. No use trying to read it.
            $this->campaignId = 0;
        }
        return 'campaign-' . $this->campaignId;
    }

    /**
     * @return string
     */
    public function getCampaign()
    {
        if ($this->campaign == false) {
            $this->campaign = Campaign::find($this->campaignId);
        }
        return $this->campaign;
    }

    /**
     * Get the url of the campaign
     * @param $campaignId
     * @return string
     */
    public function getUrl($campaignId, $with = null)
    {
        return app()->getLocale() . '/' . $this->setCampaign($campaignId) . (!empty($with) ? "/$with" : null);
    }
}
