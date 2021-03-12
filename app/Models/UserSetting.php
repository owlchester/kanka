<?php


namespace App\Models;


use App\User;
use Illuminate\Support\Arr;

/**
 * Trait UserSetting
 * @package App\Models
 *
 * @property bool $mail_newsletter
 * @property bool $mail_vote
 * @property bool $mail_release
 * @property string $patreon_email
 * @property string $patreon_fullname
 * @property int $patreon_pledge
 * @property string $newEntityWorkflow
 * @property int $pledge
 * @property string $marketplaceName
 */
trait UserSetting
{
    /**
     * @param $value
     */
    public function setPledgeAttribute($value)
    {
        $this->setSettingsOption('pledge', $value);
    }

    /**
     * Last read release
     * @param $value
     */
    public function setReleaseAttribute($value)
    {
        $this->setSettingsOption('app_release', $value);
    }

    /**
     * @param $value
     */
    public function setPatreonEmailAttribute($value)
    {
        $this->setSettingsOption('patreon_email', $value);
    }

    /**
     * @param $value
     */
    public function setPatreonFullnameAttribute($value)
    {
        $this->setSettingsOption('patreon_fullname', $value);
    }

    /**
     * @return mixed
     */
    public function getPatreonFullnameAttribute()
    {
        return Arr::get($this->settings, 'patreon_fullname', '');
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
     * @param $value
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
     * @param $value
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
     * @param $value
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
     * @param $value
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
     * @param $value
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
     * @param $value
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
     * @param $value
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
     * @param $value
     */
    public function setMarketplaceNameAttribute($value)
    {
        $this->setSettingsOption('marketplace_name', $value);
    }

    /**
     * @return mixed
     */
    public function getMarketplaceNameAttribute()
    {
        return Arr::get($this->settings, 'marketplace_name', '');
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setSettingsOption($key, $value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge([$key => $value]);
    }

    /**
     * @param $data
     * @return $this
     */
    public function saveSettings($data): self
    {
        $settings = $this->settings;
        foreach ($data as $key => $value) {
            if (empty($value) && isset($settings[$key])) {
                unset($settings[$key]);
            } elseif (!empty($value)) {
                $settings[$key] = $value;
            }
        }

        $this->settings = $settings;

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function updateSettings($data): self
    {
        $fields = ['mail_newsletter', 'mail_vote', 'mail_release'];
        foreach ($fields as $field) {
            if (!Arr::has($data, $field)) {
                continue;
            }
            $this->$field = Arr::get($data, $field, null);
        }

        return $this;
    }
}
