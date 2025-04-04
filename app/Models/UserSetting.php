<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Stevebauman\Purify\Facades\Purify;

/**
 * Trait UserSetting
 *
 * @property bool|int $mail_release
 * @property string $patreon_email
 * @property string $newEntityWorkflow
 * @property string $campaignSwitcherOrderBy
 * @property string $marketplaceName
 * @property bool $advancedMentions
 * @property bool $defaultNested
 */
trait UserSetting
{
    public function getPatreonEmailAttribute()
    {
        return Arr::get($this->settings, 'patreon_email', '');
    }

    public function getEditorAttribute()
    {
        return Arr::get($this->settings, 'editor');
    }

    /**
     * @param  string|null  $value
     */
    public function setNewEntityWorkflowAttribute($value)
    {
        $this->setSettingsOption('new_entity_workflow', $value);
    }

    public function getNewEntityWorkflowAttribute()
    {
        return Arr::get($this->settings, 'new_entity_workflow');
    }

    public function getEntityExploreAttribute()
    {
        return Arr::get($this->settings, 'entity_explore');
    }

    /**
     * @param  string|null  $value
     */
    public function setCampaignSwitcherOrderByAttribute($value)
    {
        $this->setSettingsOption('campaign_switcher_order_by', $value);
    }

    public function getCampaignSwitcherOrderByAttribute()
    {
        return Arr::get($this->settings, 'campaign_switcher_order_by');
    }

    /**
     * @param  string|null  $value
     */
    public function setAdvancedMentionsAttribute($value)
    {
        $this->setSettingsOption('advanced_mentions', $value);
    }

    public function getAdvancedMentionsAttribute()
    {
        return Arr::get($this->settings, 'advanced_mentions', false);
    }

    /**
     * @param  string|null  $value
     */
    public function setMailReleaseAttribute($value)
    {
        $this->setSettingsOption('mail_release', $value);
    }

    public function getMailReleaseAttribute()
    {
        return Arr::get($this->settings, 'mail_release', false);
    }

    /**
     * @param  string|null  $key
     * @param  string|null  $value
     */
    protected function setSettingsOption($key, $value)
    {
        $settings = $this->settings;
        $settings[$key] = $value;
        $this->settings = $settings;
    }

    /**
     * Save the user settings into the array mutator
     *
     * @return $this
     */
    public function saveSettings(array $data): self
    {
        $settings = $this->settings;
        // Flatten if provided
        if (isset($data['settings']) && is_array($data['settings'])) {
            $data = $data['settings'];
        }
        foreach ($data as $key => $value) {
            if (empty($value) && isset($settings[$key])) {
                unset($settings[$key], $settings[$key]);

            } elseif (! empty($value)) {
                if ($key == 'link') {
                    $settings[$key] = Purify::clean($value, ['URI.AllowedSchemes' => ['http', 'https']]); // Allows http & https URLs
                } else {
                    $settings[$key] = Purify::clean($value);

                }
            }
        }

        $this->settings = $settings;

        return $this;
    }

    /**
     * Save user's custom billing info
     *
     * @return $this
     */
    public function updateBillingInfo($billing): self
    {
        $profile = $this->profile;
        $profile['billing'] = $billing;
        if ($billing == '') {
            unset($profile['billing']);
        }

        $this->profile = $profile;

        return $this;
    }

    /**
     * @param  array  $data
     * @return $this
     */
    public function updateSettings($data): self
    {
        $fields = ['mail_release'];
        foreach ($fields as $field) {
            if (! Arr::has($data, $field)) {
                continue;
            }
            $this->$field = Arr::get($data, $field);
        }

        return $this;
    }

    /**
     * Get the user's public display name
     */
    public function displayName(): string
    {
        if (empty($this->settings['marketplace_name'])) {
            return (string) $this->name;
        }

        return (string) $this->settings['marketplace_name'];
    }

    /**
     * Determine if a user only wants advance mentions in their text editor
     */
    public function alwaysAdvancedMentions(): bool
    {
        return (bool) Arr::get($this->settings, 'advanced_mentions', false);
    }

    public function currency()
    {
        return Arr::get($this->settings, 'currency', 'usd');
    }

    public function getPaginationAttribute(): ?int
    {
        return (int) Arr::get($this->settings, 'pagination');
    }

    public function getDateformatAttribute(): ?string
    {
        return Arr::get($this->settings, 'date_format');
    }

    /**
     * Determine if a user is subsribed to the newsletter
     */
    public function hasNewsletter(): bool
    {
        return ! empty($this->mail_release);
    }

    /**
     * Determine if a user has the old booster nomenclature
     */
    public function hasBoosterNomenclature(): bool
    {
        if (config('app.debug') && request()->get('_legacy') == 1) {
            return true;
        }

        return Arr::get($this->settings, 'grandfathered_boost') === 1;
    }
}
