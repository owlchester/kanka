<?php

namespace App\Rules;

use App\Models\Event;
use App\Services\Events\ParticipantService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\ValidationException;

class EventParticipantState implements ValidationRule
{
    public function __construct(private ParticipantService $service, private int $campaignId, private ?Event $event) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = is_string($value) ? json_decode($value, true) : null;
        if (! is_array($data)) {
            $fail(__('validation.json', ['attribute' => $attribute]));

            return;
        }
        try {
            $this->service->validate($data, $this->campaignId, $this->event);
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $messages) {
                foreach ($messages as $message) {
                    $fail($message);
                }
            }
        }
    }
}
