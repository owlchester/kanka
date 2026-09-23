<?php

namespace App\Services\Emails;

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger as EmailTriggerEnum;
use App\Models\EmailTriggerDelivery;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Throwable;

class EmailTriggerDeliveryService
{
    public function __construct(
        protected EmailTriggerRepository $triggers,
        protected MailgunTemplateService $mailgun,
    ) {}

    public function send(
        User $user,
        EmailTriggerEnum $trigger,
        EmailAudience $audience,
        string $stage,
        string $link,
    ): bool {
        $configuration = $this->triggers->find($trigger, $audience);
        if ($configuration === null) {
            return false;
        }

        $delivery = $this->claim($user, $configuration->id, $trigger, $audience, $stage, $configuration->template);
        if ($delivery === null) {
            return false;
        }

        try {
            $messageId = $this->mailgun->send(
                $user,
                $configuration->template,
                $configuration->name,
                [
                    'username' => $user->name,
                    'link' => $link,
                ],
                $trigger->value,
            );

            $delivery->update([
                'status' => EmailTriggerDelivery::STATUS_SENT,
                'provider_message_id' => $messageId,
                'sent_at' => now(),
                'error' => null,
            ]);

            return true;
        } catch (Throwable $exception) {
            $delivery->update([
                'status' => EmailTriggerDelivery::STATUS_FAILED,
                'failed_at' => now(),
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    protected function claim(
        User $user,
        int $configurationId,
        EmailTriggerEnum $trigger,
        EmailAudience $audience,
        string $stage,
        string $template,
    ): ?EmailTriggerDelivery {
        try {
            return DB::transaction(function () use ($user, $configurationId, $trigger, $audience, $stage, $template): ?EmailTriggerDelivery {
                $delivery = EmailTriggerDelivery::query()
                    ->where('user_id', $user->id)
                    ->where('stage', $stage)
                    ->lockForUpdate()
                    ->first();

                if ($delivery?->status === EmailTriggerDelivery::STATUS_SENT) {
                    return null;
                }

                if ($delivery?->status === EmailTriggerDelivery::STATUS_SENDING
                    && $delivery->updated_at?->gt(now()->subMinutes(15))) {
                    return null;
                }

                if ($delivery === null) {
                    return EmailTriggerDelivery::query()->create([
                        'user_id' => $user->id,
                        'email_trigger_id' => $configurationId,
                        'stage' => $stage,
                        'trigger' => $trigger,
                        'audience' => $audience,
                        'template' => $template,
                        'status' => EmailTriggerDelivery::STATUS_SENDING,
                        'attempts' => 1,
                    ]);
                }

                $delivery->update([
                    'email_trigger_id' => $configurationId,
                    'trigger' => $trigger,
                    'audience' => $audience,
                    'template' => $template,
                    'status' => EmailTriggerDelivery::STATUS_SENDING,
                    'attempts' => $delivery->attempts + 1,
                    'failed_at' => null,
                    'error' => null,
                ]);

                return $delivery;
            });
        } catch (UniqueConstraintViolationException) {
            return null;
        }
    }
}
