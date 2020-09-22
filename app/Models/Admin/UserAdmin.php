<?php


namespace App\Models\Admin;


use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class UserAdmin extends User
{
    use Filterable, Sortable, Searchable;

    public $table = 'users';

    public $searchableColumns = [
        'email',
        'settings',
        'name',
    ];

    public function getForeignKey()
    {
        return 'id';
    }

    public function scopePreparedWith(Builder $builder)
    {
        return $builder->with(['referrer', 'apps']);
    }

    public function scopeOrder(Builder $builder)
    {
        return $builder->orderByDesc('created_at');
    }

    public function scopeAdmin(Builder $builder)
    {
        return $builder;
    }
}
