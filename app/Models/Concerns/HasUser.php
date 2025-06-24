<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?int $user_id
 * @property ?User $user
 */
trait HasUser
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getUserFieldName());
    }

    protected function getUserFieldName(): string
    {
        if (! property_exists($this, 'userField')) {
            return 'user_id';
        }

        return $this->userField;
    }
}
