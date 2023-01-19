<?php


namespace App\Models;


use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Stevebauman\Purify\Facades\Purify;

/**
 * Trait UserSetting
 * @package App\Models
 *
 * @property bool $mail_newsletter
 * @property bool $mail_vote
 * @property bool $mail_release
 * @property string $patreon_email
 * @property string $newEntityWorkflow
 * @property string $campaignSwitcherOrderBy
 * @property string $marketplaceName
 */
trait UserSetting
{
    public function settings()
    {
        return new Collection($this->settings);
    }

    /**
     * Last read release
     * @param string|null $value
     */
    public function setReleaseAttribute($value)
    {
        $this->setSettingsOption('app_release', $value);
    }

    /**
     * @return mixed
     */
    public function getPatreonEmailAttribute()
    {
        return Arr::get($this->settings, 'patreon_email', '');
    }

    /**
     * @return mixed
     */
    public function getReleaseAttribute()
    {
        return Arr::get($this->settings, 'app_release', null);
    }

    /**
     * @param string|null $value
     */
    public function setEditorAttribute($value)
    {
        $this->setSettingsOption('editor', $value);
    }

    /**
     * @return mixed
     */
    public function getEditorAttribute()
    {
        return Arr::get($this->settings, 'editor', null);
    }

    /**
     * @param string|null $value
     */
    public function setNewEntityWorkflowAttribute($value)
    {
        $this->setSettingsOption('new_entity_workflow', $value);
    }

    /**
     * @return mixed
     */
    public function getNewEntityWorkflowAttribute()
    {
        return Arr::get($this->settings, 'new_entity_workflow', null);
    }

    /**
     * @param string|null $value
     */
    public function setDefaultNestedAttribute($value)
    {
        $this->setSettingsOption('default_nested', $value);
    }

    /**
     * @return mixed
     */
    public function getDefaultNestedAttribute()
    {
        return Arr::get($this->settings, 'default_nested', null);
    }

    /**
     * @param string|null $value
     */
    public function setCampaignSwitcherOrderByAttribute($value)
    {
        $this->setSettingsOption('campaign_switcher_order_by', $value);
    }

    /**
     * @return mixed
     */
    public function getCampaignSwitcherOrderByAttribute()
    {
        return Arr::get($this->settings, 'campaign_switcher_order_by', null);
    }

    /**
     * @param string|null $value
     */
    public function setAdvancedMentionsAttribute($value)
    {
        $this->setSettingsOption('advanced_mentions', $value);
    }

    /**
     * @return mixed
     */
    public function getAdvancedMentionsAttribute()
    {
        return Arr::get($this->settings, 'advanced_mentions', false);
    }


    /**
     * @param string|null $value
     */
    public function setMailNewsletterAttribute($value)
    {
        $this->setSettingsOption('mail_newsletter', $value);
    }

    /**
     * @return mixed
     */
    public function getMailNewsletterAttribute()
    {
        return Arr::get($this->settings, 'mail_newsletter', false);
    }

    /**
     * @param string|null $value
     */
    public function setMailReleaseAttribute($value)
    {
        $this->setSettingsOption('mail_release', $value);
    }

    /**
     * @return mixed
     */
    public function getMailReleaseAttribute()
    {
        return Arr::get($this->settings, 'mail_release', false);
    }


    /**
     * @param string|null $value
     */
    public function setMailVoteAttribute($value)
    {
        $this->setSettingsOption('mail_vote', $value);
    }

    /**
     * @return mixed
     */
    public function getMailVoteAttribute()
    {
        return Arr::get($this->settings, 'mail_vote', false);
    }

    /**
     * @param string|null $key
     * @param string|null $value
     */
    protected function setSettingsOption($key, $value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge([$key => $value]);
    }

    /**
     * Save the user settings into the array mutator
     * @param array $data
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
                unset($settings[$key]);
            } elseif (!empty($value)) {
                $settings[$key] = Purify::clean($value);
            }
        }

        $this->settings = $settings;

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function updateSettings($data): self
    {
        $fields = ['mail_release'];
        foreach ($fields as $field) {
            if (!Arr::has($data, $field)) {
                continue;
            }
            $this->$field = Arr::get($data, $field, null);
        }

        return $this;
    }

    /**
     * Get the user's public display name
     * @return string
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
     * @return bool
     */
    public function alwaysAdvancedMentions(): bool
    {
        return (bool) Arr::get($this->settings, 'advanced_mentions', false);
    }

    public function currency()
    {
        return Arr::get($this->settings, 'currency', 'usd');
    }

    public function getPaginationAttribute(): int|null
    {
        return (int) Arr::get($this->settings, 'pagination');
    }

    public function getDateformatAttribute(): string|null
    {
        return Arr::get($this->settings, 'date_format');
    }
}
