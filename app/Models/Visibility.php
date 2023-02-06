<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Visibility
 * @package App\Models
 *
 * @property int $id
 * @property string $code
 */
class Visibility extends Model
{
    /**
     * Visibility constants
     */
    public const VISIBILITY_ALL = 1;
    public const VISIBILITY_ADMIN = 2;
    public const VISIBILITY_ADMIN_SELF = 3;
    public const VISIBILITY_SELF = 4;
    public const VISIBILITY_MEMBERS = 5;

    /**
     * Visibility strings for old tables that haven't been migrated
     */
    public const VISIBILITY_ALL_STR = 'all';
    public const VISIBILITY_ADMIN_STR = 'admin';
    public const VISIBILITY_SELF_STR = 'self';
    public const VISIBILITY_MEMBERS_STR = 'members';
    public const VISIBILITY_ADMIN_SELF_STR = 'admin-self';

    public $fillable = [
        'code'
    ];
}
