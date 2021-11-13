<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campaign;

class CampaignController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.campaigns';
    protected $route = 'admin.campaigns';
    protected $trans = 'admin/campaigns';

    /**
     * @var string
     */
    protected $model = \App\Models\Campaign::class;

    public $createAction = false;

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

    public function show(Campaign $campaign)
    {
        $with = [
        ];
        return $this->crudShow($campaign, $with);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        return $this->crudDestroy($campaign);
    }
}
