<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\User;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status_id
 * @property int $category_id
 * @property int $created_by
 * @property int $upvote_count
 * @property User|null $user
 * @property FeatureCategory $category
 * @property FeatureStatus $status
 */
class Feature extends Model
{
    public $fillable = [
        'name',
        'description',
        'category_id',
        'status_id'
    ];

    public $with = [
        'user',
        'category',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function votes()
    {
        return $this->hasMany(FeatureUpvote::class);
    }
}
