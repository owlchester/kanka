<?php

namespace App\Http\Requests;

use App\Enums\Widget;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'entity_id' => 'nullable|exists:entities,id',
            'dashboard_id' => 'nullable|exists:campaign_dashboards,id',
            'config.order' => 'nullable|in:name_asc,name_desc,oldest',
            'entity_type_id' => 'nullable|exists:entity_types,id',
        ];
    }
}
