<?php


namespace App\Models;


use App\User;
use Illuminate\Support\Arr;

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
        $this->setSettingsOption('release', $value);
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
        return $this->settings['patreon_fullname'];
    }

    /**
     * @return mixed
     */
    public function getPatreonEmailAttribute()
    {
        return $this->settings['patreon_email'];
    }

    /**
     * @return mixed
     */
    public function getReleaseAttribute()
    {
        return Arr::get($this->settings, 'release', null);
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
    public function saveSettings($data)
    {
        // Todo: refactor into an array
        $this->editor = Arr::get($data, 'editor', null);
        if (empty($this->editor)) {
            unset($this->attributes['settings']['editor']);
        }
        $this->default_nested = Arr::get($data, 'default_nested', null);
        if (empty($this->default_nested)) {
            unset($this->attributes['settings']['default_nested']);
        }
        $this->advanced_mentions = Arr::get($data, 'advanced_mentions', null);
        if (empty($this->advanced_mentions)) {
            unset($this->attributes['settings']['advanced_mentions']);
        }
        return $this;
    }
}