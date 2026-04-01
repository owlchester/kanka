<?php

namespace App\Http\Controllers\Settings;

use App\Facades\UserCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsLayout;
use App\Models\User;

class AppearanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index()
    {
        $highlight = request()->get('highlight');
        $from = request()->get('from');

        $editorOptions = [
            '' => __('settings/appearance.editors.default', ['name' => 'Summernote']),
        ];
        if (auth()->user()->created_at->isBefore('2023-01-09 12:00:00')) {
            $editorOptions['legacy'] = __('settings/appearance.editors.legacy', ['name' => 'TinyMCE 4']);
        }
        $editorOptions['tiptap'] = __('settings/appearance.editors.tiptap');

        return view('settings.appearance')
            ->with('highlight', $highlight)
            ->with('from', $from)
            ->with('editorOptions', $editorOptions);
    }

    public function update(StoreSettingsLayout $request)
    {
        if ($request->ajax()) {
            return response()->json();
        }
        /** @var User $user */
        $user = $request->user();
        $settingFields = $request->only([
            'editor', 'advanced_mentions', 'new_entity_workflow',
            'campaign_switcher_order_by', 'date_format',
        ]);
        $user
            ->saveSettings($settingFields)
            ->update($request->only(['theme']));

        // refresh user campaigns in cache if order by has changed
        if ($request->has('campaign_switcher_order_by')) {
            UserCache::clear();
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
