<?php

namespace App\Http\Controllers\Admin;

use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CampaignController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.campaigns';
    protected $route = 'admin.campaigns';

    /**
     * @var string
     */
    protected $model = \App\Campaign::class;

    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->filters = [
            'name',
            'visibility',
        ];

        parent::__construct();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        return $this->crudDestroy($campaign);
    }
}
