
@inject('campaignService', 'App\Services\CampaignService')
@include('layouts.callouts.limit', ['texts' => [__('campaigns/limits.entities')], 'skipImage' => true])
