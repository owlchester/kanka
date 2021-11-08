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
    public $fillable = [
        'code'
    ];
}
