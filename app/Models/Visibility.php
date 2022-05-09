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
    const VISIBILITY_ALL = 1;
    const VISIBILITY_ADMIN = 2;
    const VISIBILITY_ADMIN_SELF = 3;
    const VISIBILITY_SELF = 4;
    const VISIBILITY_MEMBERS = 5;

    /**
     * Visibility strings for old tables that haven't been migrated
     */
    const VISIBILITY_ALL_STR = 'all';
    const VISIBILITY_ADMIN_STR = 'admin';
    const VISIBILITY_SELF_STR = 'self';
    const VISIBILITY_MEMBERS_STR = 'members';
    const VISIBILITY_ADMIN_SELF_STR = 'admin-self';

    public $fillable = [
        'code'
    ];
}
