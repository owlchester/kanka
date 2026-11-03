<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Rules\EventParticipantState;
use App\Services\Events\ParticipantService;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

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
        $rules = [
            'date' => 'nullable|string|max:191',
        ];

        $campaign = request()->route('campaign');
        $event = request()->route('event') ?? request()->route('entity')?->child;
        if ($campaign) {
            $rules['event_participants'] = ['sometimes', 'string', new EventParticipantState(
                app(ParticipantService::class), $campaign->id, $event instanceof Event ? $event : null
            )];
        }

        return $this->entityRules($rules);
    }
}
