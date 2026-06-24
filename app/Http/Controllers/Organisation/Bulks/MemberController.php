<?php

namespace App\Http\Controllers\Organisation\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Models\Campaign;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;

    public function index(Request $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('member', $organisation);

        $this->campaign = $campaign;
        $action = $request->get('action');
        $models = $request->get('model');
        if (! in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->campaign($campaign)->bulkBatch(
                route('organisations.organisation_members.bulk', [$campaign, $organisation]),
                '_organisation-member',
                $models
            );
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $count = $this->bulkProcess($request, OrganisationMember::class);

        return redirect()
            ->route('organisations.members', [$campaign, $organisation])
            ->with('success', trans_choice('organisations.members.bulks.' . $action, $count, ['count' => $count]));
    }
}
