<?php
/**
 * Description of
 *
 * @author Jeremy Payne hello@kanka.io
 * 19/05/2020
 */


namespace App\Services;


use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class LfgmService
{
    /**
     * @param string $uuid
     * @return string
     * @throws \Exception
     */
    public function uuid(string $uuid): string
    {
        preg_match('/[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}/', $uuid, $m);
        $real = Arr::first($m);
        if (!empty($real)) {
            return $real;
        }
        throw new \Exception();
    }

    /**
     * @param Request $request
     * @return Campaign
     * @throws TranslatableException
     */
    public function sync(Request $request): Campaign
    {
        $campaignId = $request->post('campaign');
        $uuid = $this->uuid($request->post('uuid'));

        // First we make sure we have access to the new campaign.
        $campaign = Auth::user()->campaigns()->where('campaign_id', $campaignId)->first();
        if (empty($campaign)) {
            throw new TranslatableException('crud.move.errors.unknown_campaign');
        }

        // Can the user create an entity of that type on the new campaign?
        if (!Auth::user()->can('create', [Note::class, null, $campaign])) {
            throw new TranslatableException('crud.move.errors.permission');
        }

        CampaignLocalization::forceCampaign($campaign);
        $note = Note::create([
            'name' => 'LookingForGM Events',
            'entry' => '<iframe src="https://lookingforgm.com/campaign/' . $uuid . '/kanka/" style="width: 100%; border: none;" height="400" class="lfgm-iframe"></iframe>',
            'campaign_id' => $campaign->id
        ]);

        // Add the note as a widget
        $last = CampaignDashboardWidget::orderBy('position', 'desc')->first();
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $campaign->id,
            'entity_id' => $note->entity->id,
            'widget' => CampaignDashboardWidget::WIDGET_PREVIEW,
            'width' => 6, // half
            'config' => '{"full":"1"}',
            'position' => $last ? $last->position++ : 1,
        ]);
        $widget->save();

        return $campaign;
    }
}
