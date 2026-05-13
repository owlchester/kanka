<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnboardingWidgetController extends Controller
{
    public function state(Campaign $campaign): JsonResponse
    {
        $this->authorize('access', $campaign);

        $settings = $campaign->settings ?? [];
        $widgetState = $settings['onboarding_widget'] ?? null;

        if ($widgetState !== null) {
            return response()->json($widgetState);
        }

        $existingIntent = $settings['onboarding'] ?? null;
        $validIntents = ['worldbuilding', 'campaign', 'story'];
        $hasOldIntent = in_array($existingIntent, $validIntents);

        $newState = [
            'step' => $hasOldIntent ? 2 : 1,
            'intent' => $hasOldIntent ? $existingIntent : null,
            'entities' => [],
            'dismissed' => false,
        ];

        $settings['onboarding_widget'] = $newState;
        $campaign->update(['settings' => $settings]);

        return response()->json($newState);
    }

    public function progress(Request $request, Campaign $campaign): JsonResponse
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'step' => 'required|integer|min:1|max:6',
            'intent' => 'nullable|in:worldbuilding,campaign,story',
            'entity_id' => 'nullable|integer',
        ]);

        $settings = $campaign->settings ?? [];
        $state = $settings['onboarding_widget'] ?? [
            'step' => 1,
            'intent' => null,
            'entities' => [],
            'dismissed' => false,
        ];

        $state['step'] = $validated['step'];

        if (($validated['intent'] ?? null) !== null) {
            $state['intent'] = $validated['intent'];
        }

        if (($validated['entity_id'] ?? null) !== null) {
            $state['entities'][] = $validated['entity_id'];
        }

        $settings['onboarding_widget'] = $state;
        $campaign->update(['settings' => $settings]);

        CampaignEvent::create([
            'campaign_id' => $campaign->id,
            'created_by' => auth()->user()->id,
            'event' => 'onboarding_widget_step_' . $validated['step'],
        ]);

        return response()->json($state);
    }

    public function dismiss(Request $request, Campaign $campaign): JsonResponse
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'step' => 'required|integer|min:1|max:6',
            'widget_id' => 'required|integer',
        ]);

        $settings = $campaign->settings ?? [];
        $state = $settings['onboarding_widget'] ?? [
            'step' => $validated['step'],
            'intent' => null,
            'entities' => [],
            'dismissed' => false,
        ];

        $state['dismissed'] = true;
        $settings['onboarding_widget'] = $state;
        $campaign->update(['settings' => $settings]);

        CampaignEvent::create([
            'campaign_id' => $campaign->id,
            'created_by' => auth()->user()->id,
            'event' => 'onboarding_widget_dismissed',
            'metadata' => ['step' => $validated['step']],
        ]);

        CampaignDashboardWidget::where('id', $validated['widget_id'])
            ->where('campaign_id', $campaign->id)
            ->delete();

        return response()->json(['success' => true]);
    }
}
