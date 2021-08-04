<?php


namespace App\Services;


use App\Models\Campaign;

class BreadcrumbService
{
    /** @var Campaign */
    protected $campaign;

    /**
     * @return Campaign
     */
    protected function campaign()
    {
        if (empty($this->campaign)) {
            $this->campaign = \App\Facades\CampaignLocalization::getCampaign();
        }

        return $this->campaign;
    }

    /**
     * @param string $name
     * @return string
     */
    public function index(string $name): string
    {
        // If the user activated nested views by default, go back to it.
        $entityIndexRoute = route($name . '.index');
        if ($this->campaign()->defaultToNested() || (auth()->check() && auth()->user()->defaultNested)) {
            if (\Illuminate\Support\Facades\Route::has($name . '.tree')) {
                $entityIndexRoute = route($name . '.tree');
            }
        }
        return $entityIndexRoute;
    }
}
