<?php

namespace App\Console\Commands\Tests;

use App\Models\EmailTrigger;
use App\Models\User;
use App\Services\Emails\EmailTriggerRepository;
use App\Services\Emails\MailgunTemplateService;
use App\Services\Emails\OnboardingEmailService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class TestOnboardingEmail extends Command
{
    protected $signature = 'test:onboarding-email {user?} {--to=}';

    protected $description = 'Send a test onboarding email through Mailgun';

    public function handle(
        EmailTriggerRepository $triggers,
        OnboardingEmailService $onboarding,
        MailgunTemplateService $mailgun,
    ): int {
        $user = $this->user();
        if ($user === null) {
            return self::FAILURE;
        }

        $recipient = $this->option('to') ?: $this->ask('Send to', $user->email);
        if (! is_string($recipient) || filter_var($recipient, FILTER_VALIDATE_EMAIL) === false) {
            $this->error('Please provide a valid recipient email address.');

            return self::FAILURE;
        }

        $configurations = $triggers->all();
        if ($configurations->isEmpty()) {
            $this->error('No email trigger configurations are available.');

            return self::FAILURE;
        }

        $configuration = $this->chooseConfiguration($configurations);
        if ($configuration === null) {
            return self::FAILURE;
        }

        $campaign = $onboarding->campaignForAudience($user, $configuration->audience);
        if ($campaign === null) {
            $this->error('The user has no campaign for the selected audience.');

            return self::FAILURE;
        }

        $messageId = $mailgun->send(
            $user,
            $configuration->template,
            $configuration->name,
            [
                'username' => $user->name,
                'link' => route('dashboard', ['campaign' => $campaign]),
            ],
            $configuration->trigger_id->value,
            $recipient,
        );

        $this->info("Sent {$configuration->template} to {$recipient} ({$messageId}).");

        return self::SUCCESS;
    }

    protected function user(): ?User
    {
        $userId = $this->argument('user') ?: $this->ask('User ID');
        $user = User::find((int) $userId);

        if ($user === null) {
            $this->error("User [{$userId}] not found.");
        }

        return $user;
    }

    /**
     * @param  Collection<int, EmailTrigger>  $configurations
     */
    protected function chooseConfiguration(Collection $configurations): ?EmailTrigger
    {
        $options = $configurations
            ->map(fn (EmailTrigger $configuration): string => $this->configurationLabel($configuration))
            ->values()
            ->all();
        $selected = $this->choice('Email configuration', $options);

        return $configurations->values()->first(
            fn (EmailTrigger $configuration, int $index): bool => $options[$index] === $selected
        );
    }

    protected function configurationLabel(EmailTrigger $configuration): string
    {
        $status = $configuration->is_active ? 'active' : 'inactive';
        $audience = $configuration->audience?->value ?? 'unknown';
        $cohort = $configuration->cohort === null ? 'default' : (string) $configuration->cohort;

        return sprintf(
            '[%s] #%d %s | %s / %s | cohort %s',
            $status,
            $configuration->id,
            $configuration->name,
            $configuration->trigger_id->value,
            $audience,
            $cohort,
        );
    }
}
