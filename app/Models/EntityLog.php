<?php

namespace App\Models;

use App\Http\Requests\HistoryRequest;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class EntityLog
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $campaign_id
 * @property integer $created_by
 * @property integer $impersonated_by
 * @property integer $action
 * @property integer $post_id
 * @property string|array  $changes
 * @property Entity $entity
 * @property User $user
 * @property User $impersonator
 * @property Campaign $campaign
 */
class EntityLog extends Model
{
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
        'entity_id',
        'created_by',
        'impersonated_by',
        'action',
        'campaign_id',
    ];

    public $casts = [
        'changes' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function impersonator()
    {
        return $this->belongsTo('App\User', 'impersonated_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\EntityNote', 'post_id');
    }

    /**
     * @return string
     */
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
            return 'fa-trash';
        } elseif ($this->action == self::ACTION_RESTORE) {
            return 'fa-history';
        }
        return 'fa-question-circle';
    }
    public function actionBackground(): string
    {
        if ($this->action == self::ACTION_CREATE || $this->action == self::ACTION_CREATE_POST) {
            return 'bg-green';
        } elseif ($this->action == self::ACTION_UPDATE || $this->action == self::ACTION_UPDATE_POST) {
            return 'bg-blue';
        } elseif ($this->action == self::ACTION_REORDER_POST) {
            return 'bg-yellow';
        } elseif ($this->action == self::ACTION_DELETE || $this->action == self::ACTION_DELETE_POST) {
            return 'bg-red';
        } elseif ($this->action == self::ACTION_RESTORE) {
            return 'bg-orange';
        }
        return 'bg-gray';
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecent(Builder $query)
    {
        return $query->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');
    }

    /**
     * @param Builder $query
     * @param int $action
     * @return Builder
     */
    public function scopeAction(Builder $query, int $action)
    {
        return $query->where(['action' => $action]);
    }

    /**
     * Replace the field edited with it's translated name
     * @param string $transKey
     * @param string $attribute
     * @return string
     */
    public function attributeKey(string $transKey, string $attribute): string
    {
        // Try with crud first
        $name = Str::beforeLast($attribute, '_id');
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
        return '<i>' . __('crud.users.unknown') . '</i>';
    }

    /**
     * Automatically prune old elements from the db
     * @return Builder
     */
    public function prunable(): Builder
    {
        $delay = config('entities.logs_delete');
        return static::where('updated_at', '<=', now()->subDays($delay));
    }

    public function day(): int
    {
        return $this->created_at->format('Ymd');
    }

    public function userLink(): string
    {
        if (!$this->user) {
            return '<i>' . __('crud.users.unknown') . '</i>';
        }
        return '<strong>' . $this->user->name . '</strong>';
    }

    public function entityLink(): string
    {
        if (!$this->entity) {
            return link_to_route('recovery', __('history.unknown.entity'));
        }
        return $this->entity->tooltipedLink();
    }

    public function actions($action): array
    {
        if ($action == self::ACTION_CREATE || $action == self::ACTION_CREATE_POST) {
            return [ self::ACTION_CREATE, self::ACTION_CREATE_POST ];
        } elseif ($action == self::ACTION_UPDATE) {
            return [self::ACTION_UPDATE, self::ACTION_UPDATE_POST, self::ACTION_REORDER_POST];
        } elseif ($action == self::ACTION_DELETE) {
            return [self::ACTION_DELETE, self::ACTION_DELETE_POST];
        } elseif ($action == self::ACTION_RESTORE) {
            return [self::ACTION_RESTORE];
        }
    }

    /**
     * @param Builder $builder
     * @param HistoryRequest $request
     * @return Builder
     */
    public function scopeFilter(Builder $builder, HistoryRequest $request): Builder
    {
        if ($request->filled('user')) {
            $builder->where($this->getTable() . '.created_by', (int) $request->get('user'));
        }
        if ($request->filled('action')) {
            $actions = $this->actions($request->get('action'));
            $builder->where(function ($query) use ($actions) {
                foreach ($actions as $action) {
                    $query->orWhere($this->getTable() . '.action', (int) $action);
                }
            });
        }
        return $builder;
    }
}
