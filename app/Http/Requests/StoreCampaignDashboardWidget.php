<?php

namespace App\Http\Requests;

use App\Enums\Widget;
use App\Models\CampaignDashboard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class StoreCampaignDashboardWidget extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'widget' => ['required', new Enum(Widget::class)],
            'entity_id' => [
                'nullable',
                Rule::exists('entities', 'id')->where('campaign_id', $this->route('campaign')?->id),
            ],
            'target_type' => ['nullable', Rule::in(['', 'entity', 'dashboard'])],
            'target_dashboard_id' => [
                'nullable',
                Rule::exists('campaign_dashboards', 'id')->where('campaign_id', $this->route('campaign')?->id),
            ],
            'dashboard_id' => 'nullable|exists:campaign_dashboards,id',
            'config.order' => 'nullable|string|in:name_asc,name_desc,oldest',
            'entity_type_id' => 'nullable|exists:entity_types,id',
            'config.folder_id' => ['required_if:widget,gallery', Rule::exists('images', 'id')->where('is_folder', true)],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            $campaign = $this->route('campaign');
            if ($this->input('widget') !== Widget::Header->value || $this->input('target_type') !== 'dashboard' || $campaign?->premium()) {
                return;
            }

            $existingWidget = $this->route('campaignDashboardWidget');
            $existingDashboardTarget = $existingWidget?->target;
            if ($existingDashboardTarget instanceof CampaignDashboard && (string) $existingDashboardTarget->id === (string) $this->input('target_dashboard_id')) {
                return;
            }

            $validator->errors()->add('target_dashboard_id', __('dashboard.widgets.validation.premium-dashboard-target'));
        }];
    }
}
