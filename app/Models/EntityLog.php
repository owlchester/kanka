<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class EntityLog
 *
 * @property int $campaign_id
 * @property int $created_by
 * @property int $impersonated_by
 * @property int $action
 * @property null|string|array $changes
 * @property ?User $impersonator
 * @property Campaign $campaign
 * @property Carbon $created_at
 * @property int $parent_id
 * @property string $parent_type
 * @property-read Entity|Post $parent
 */
class EntityLog extends Model
{
    use HasUser;
    use MassPrunable;

    public const ACTION_CREATE = 1;

    public const ACTION_UPDATE = 2;

    public const ACTION_DELETE = 3;

    public const ACTION_RESTORE = 4;

    public const ACTION_DELETE_POST = 5;

    public const ACTION_REORDER_POST = 6;

    public const ACTION_CREATE_POST = 7;

    public const ACTION_UPDATE_POST = 8;

    public $fillable = [
        'created_by',
        'impersonated_by',
        'action',
        'campaign_id',
    ];

    public $casts = [
        'changes' => 'array',
    ];

    protected array $custom = [
        'header_uuid' => 'fields.header-image.title',
        'image_uuid' => 'crud.fields.image',
        'is_template' => 'entities/actions.templates.toggle',
        'is_attributes_private' => 'entities/attributes.fields.is_private',
    ];

    protected string $userField = 'created_by';

    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, $this>
     */
    public function impersonator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'impersonated_by');
    }

    public function actionCode(): string
    {
        if ($this->action == self::ACTION_CREATE) {
            return 'create';
        } elseif ($this->action == self::ACTION_UPDATE) {
            return 'update';
        } elseif ($this->action == self::ACTION_DELETE) {
            return 'delete';
        } elseif ($this->action == self::ACTION_RESTORE) {
            return 'restore';
        } elseif ($this->action == self::ACTION_CREATE_POST) {
            return 'create_post';
        } elseif ($this->action == self::ACTION_UPDATE_POST) {
            return 'update_post';
        } elseif ($this->action == self::ACTION_DELETE_POST) {
            return 'delete_post';
        } elseif ($this->action == self::ACTION_REORDER_POST) {
            return 'reorder_post';
        }

        return 'unknown';
    }

    public function actionIcon(): string
    {
        if ($this->action == self::ACTION_CREATE || $this->action == self::ACTION_CREATE_POST) {
            return 'fa-plus';
        } elseif ($this->action == self::ACTION_UPDATE || $this->action == self::ACTION_UPDATE_POST) {
            return 'fa-pencil';
        } elseif ($this->action == self::ACTION_REORDER_POST) {
            return 'fa-arrows-rotate';
        } elseif ($this->action == self::ACTION_DELETE || $this->action == self::ACTION_DELETE_POST) {
            return 'fa-trash-can';
        } elseif ($this->action == self::ACTION_RESTORE) {
            return 'fa-history';
        }

        return 'fa-question-circle';
    }

    public function actionBackground(): string
    {
        if ($this->action == self::ACTION_CREATE || $this->action == self::ACTION_CREATE_POST) {
            return 'bg-green-300';
        } elseif ($this->action == self::ACTION_UPDATE || $this->action == self::ACTION_UPDATE_POST) {
            return 'bg-blue-200';
        } elseif ($this->action == self::ACTION_REORDER_POST) {
            return 'bg-yellow-300';
        } elseif ($this->action == self::ACTION_DELETE || $this->action == self::ACTION_DELETE_POST) {
            return 'bg-red-300';
        } elseif ($this->action == self::ACTION_RESTORE) {
            return 'bg-orange-300';
        }

        return 'bg-gray';
    }

    /**
     * @return Builder
     */
    public function scopeRecent(Builder $query)
    {
        return $query->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');
    }

    /**
     * @return Builder
     */
    public function scopeAction(Builder $query, int $action)
    {
        return $query->where(['action' => $action]);
    }

    public function isBoolean(string $attribute): bool
    {
        return Str::startsWith($attribute, ['has_', 'is_']);
    }

    /**
     * Replace the field edited with it's translated name
     */
    public function attributeKey(string $transKey, string $attribute): string
    {
        $name = Str::beforeLast($attribute, '_id');

        // Entity name
        $key = 'entities.' . $name;
        $translation = __($key);
        if ($key !== $translation) {
            return $translation;
        }

        // Crud field
        $key = 'crud.fields.' . $name;
        $translation = __($key);
        if ($key !== $translation) {
            return $translation;
        }

        $key = $transKey . '.fields.' . $name;
        $translation = __($key);
        if ($key !== $translation) {
            return $translation;
        }

        // Custom mapping
        if (isset($this->custom[$name])) {
            return __($this->custom[$name]);
        }

        if (app()->isProduction()) {
            return '<i data-key="' . $transKey . '" data-attr="' . $name . '">' . __('crud.users.unknown') . '</i>';
        }

        return '<i data-key="' . $transKey . '" data-attr="' . $name . '">' . $name . '</i>';
    }

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        $delay = config('entities.logs_delete');

        return static::where('updated_at', '<=', now()->subDays($delay));
    }

    public function day(): int
    {
        return (int) $this->created_at->format('Ymd');
    }

    public function userLink(): string
    {
        if (! $this->user) {
            return '<i>' . __('crud.users.unknown') . '</i>';
        }

        return '<strong>' . $this->user->name . '</strong>';
    }

    public function actions($action): array
    {
        if ($action == self::ACTION_CREATE || $action == self::ACTION_CREATE_POST) {
            return [self::ACTION_CREATE, self::ACTION_CREATE_POST];
        } elseif ($action == self::ACTION_UPDATE) {
            return [self::ACTION_UPDATE, self::ACTION_UPDATE_POST, self::ACTION_REORDER_POST];
        } elseif ($action == self::ACTION_DELETE) {
            return [self::ACTION_DELETE, self::ACTION_DELETE_POST];
        } elseif ($action == self::ACTION_RESTORE) {
            return [self::ACTION_RESTORE];
        } elseif ($action == self::ACTION_REORDER_POST) {
            return [self::ACTION_REORDER_POST];
        }

        return [];
    }

    public function scopeFilter(Builder $builder, array $filters): Builder
    {
        $user = Arr::get($filters, 'user');
        if (! empty($user)) {
            $builder->where($this->getTable() . '.created_by', (int) $user);
        }
        $action = Arr::get($filters, 'action');
        if (! empty($action)) {
            $actions = $this->actions($action);
            $builder->whereIn($this->getTable() . '.action', $actions);
        }
        if (Arr::has($filters, 'q')) {
            $q = mb_trim(Arr::get($filters, 'q'));
            $builder->whereLike('changes', '%' . $q . '%');
        }

        return $builder;
    }

    public function isPost(): bool
    {
        return $this->parent_type == Post::class;
    }
}
