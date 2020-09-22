<?php


namespace App\Models;


use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Referral
 * @package App\Models
 *
 * @property int $id
 * @property string $code
 * @property boolean $is_valid
 *
 * @property User[] $users
 */
class Referral extends Model
{
    use Filterable, Sortable, Searchable;

    public $fillable = [
        'code',
        'is_valid',
    ];

    public $sortableColumns = [
        'code',
        'is_valid',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
