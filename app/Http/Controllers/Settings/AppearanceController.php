<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsLayout;
use App\Services\PaginationService;
use Carbon\Carbon;

class AppearanceController extends Controller
{
    protected PaginationService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PaginationService $paginationService)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $paginationService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $highlight = request()->get('highlight');
        $from = request()->get('from');
        $date = Carbon::parse('2023-01-09 12:00:00');
        $created = Carbon::parse(auth()->user()->created_at);
        $textEditorSelect = $created->lessThan($date);
        $paginationOptions = $this->service->options();
        $paginationDisabled = $this->service->disabled();

        return view('settings.appearance')
            ->with('paginationOptions', $paginationOptions)
            ->with('paginationDisabled', $paginationDisabled)
            ->with('highlight', $highlight)
            ->with('from', $from)
            ->with('textEditorSelect', $textEditorSelect);
    }

    /**
     */
    public function update(StoreSettingsLayout $request)
    {
        if ($request->ajax()) {
            return response()->json();
        }
        /** @var \App\Models\User $user */
        $user = $request->user();
        $settingFields = $request->only([
            'editor', 'advanced_mentions', 'new_entity_workflow',
            'campaign_switcher_order_by', 'pagination', 'date_format',
            'entity_explore'
        ]);
        $user
            ->saveSettings($settingFields)
            ->update($request->only(['theme']));

        //refresh user campaigns in cache if order by has changed
        if ($request->has('campaign_switcher_order_by')) {
            \App\Facades\UserCache::clear();
        }

        if ($request->filled('from')) {
            $from = base64_decode($request->get('from'));
            return redirect()
                ->to($from)
                ->with('success', __('settings/appearance.success'));
        }

        return redirect()
            ->route('settings.appearance')
            ->with('success', __('settings/appearance.success'));
    }
}
