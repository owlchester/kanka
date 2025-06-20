<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\Models\Concerns\Sanitizable;
use App\Observers\FeatureObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \App\Enums\FeatureStatus $status_id
 * @property int $category_id
 * @property ?int $created_by
 * @property int $upvote_count
 * @property FeatureCategory $category
 * @property FeatureStatus $status
 *
 * @method static self|Builder visible()
 * @method static self|Builder approved()
 * @method static self|Builder search(string $search)
 */
#[ObservedBy([FeatureObserver::class])]
class Feature extends Model
{
    use HasUser;
    use Sanitizable;

    public $fillable = [
        'name',
        'description',
    ];

    protected string $userField = 'created_by';

    protected array $sanitizable = [
        'name',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FeatureCategory::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(FeatureStatus::class);
    }

    public function uservote(): HasOne
    {
        return $this->hasOne(FeatureVote::class)
            ->where('user_id', auth()->user()->id);
    }

    public function featureFiles(): HasMany
    {
        return $this->hasMany(FeatureFile::class, 'feature_id', 'id');
    }

    public function scopeApproved(Builder $builder): Builder
    {
        return $builder->whereIn('status_id', [\App\Enums\FeatureStatus::Approved])
            ->orderBy('upvote_count', 'DESC');
    }

    public function scopeVisible(Builder $builder): Builder
    {
        $statuses = [
            \App\Enums\FeatureStatus::Approved,
            \App\Enums\FeatureStatus::Later,
            \App\Enums\FeatureStatus::Next,
            \App\Enums\FeatureStatus::Now,
            \App\Enums\FeatureStatus::Done,
        ];

        return $builder->whereIn('status_id', $statuses)
            ->orderBy('upvote_count', 'DESC');
    }

    public function scopeSearch(Builder $builder, string $search): Builder
    {
        if (empty($search) | mb_strlen($search) < 3) {
            return $builder;
        }

        return $builder->where('name', 'like', '%' . $search . '%');
    }

    public function isUpvoted(): bool
    {
        if (auth()->guest()) {
            return false;
        }

        return auth()->user()->upvotes()->forFeature($this)->count() === 1;
    }

    public function cleanDescription(): string
    {
        if (Str::startsWith($this->description, '<p>')) {
            return $this->description;
        }
        return '<p>' . nl2br($this->description) .'</p>';
    }
}
