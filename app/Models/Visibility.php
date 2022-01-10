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

    public $fillable = [
        'code'
    ];
}
