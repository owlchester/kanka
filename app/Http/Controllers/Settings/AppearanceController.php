<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsLayout;
use App\Services\PaginationService;

class AppearanceController extends Controller
{
    public function __construct(protected PaginationService $service)
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index()
    {
        $highlight = request()->get('highlight');
        $from = request()->get('from');
        $paginationOptions = $this->service->user(auth()->user())->options();
        $paginationDisabled = $this->service->disabled();

        $editorOptions = [
            '' => __('settings/appearance.editors.default', ['name' => 'Summernote']),
        ];
        if (auth()->user()->created_at->isBefore('2023-01-09 12:00:00')) {
            $editorOptions['legacy'] = __('settings/appearance.editors.legacy', ['name' => 'TinyMCE 4']);
        }
        $editorOptions['tiptap'] = __('settings/appearance.editors.tiptap');

        return view('settings.appearance')
            ->with('paginationOptions', $paginationOptions)
            ->with('paginationDisabled', $paginationDisabled)
            ->with('highlight', $highlight)
            ->with('from', $from)
            ->with('editorOptions', $editorOptions);
    }

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
            'entity_explore',
        ]);
        $user
            ->saveSettings($settingFields)
            ->update($request->only(['theme']));

        // refresh user campaigns in cache if order by has changed
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
