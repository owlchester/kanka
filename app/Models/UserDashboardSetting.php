<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDashboardSetting extends Model
{
    /**
     * @var string
     */
    public $table = 'user_dashboard_settings';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'recent_count',
        'characters',
        'events',
        'families',
        'items',
        'journals',
        'locations',
        'notes',
        'organisations',
        'quests',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function has($entity)
    {
        return $this->$entity;
    }
}
