<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This model/table keeps track of all the jobs running in the background and their results.
 *
 * @property string $name
 * @property string $result
 * @property string $config
 */
class JobLog extends Model
{
    public $fillable = [
        'name',
        'result',
        'config',
    ];

    /*public $casts = [
        'config' => 'array'
    ];*/
}
