<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Campaign extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'locale', 'description', 'image', 'join_token'
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->using('App\CampaignUser');
    }

    /**
     * @return mixed
     */
    public function members()
    {
        return $this->hasMany('App\CampaignUser');
    }

    /**
     * @return bool
     */
    public function owner()
    {
        foreach ($this->members as $member) {
            if ($member->user_id == Auth::user()->id && $member->role == 'owner') {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function member()
    {
        foreach ($this->members as $member) {
            if ($member->user_id == Auth::user()->id && $member->role == 'member') {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function user()
    {
        foreach ($this->members as $member) {
            if ($member->user_id == Auth::user()->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generate a new token
     */
    public function newToken()
    {
        $this->join_token = $this->getToken();
        $this->save();
    }

    /**
     * Generate a new token
     * @return string
     */
    public function getToken()
    {
        return str_random(80); //sha1(uniqid() . $this->name . time());
    }
}
