<?php


namespace App\Models\Scopes;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Trait UserScope
 * @package App\Models\Scopes
 *
 * @method static self|Builder today()
 * @method static self|Builder startOfMonth()
 * @method static self|Builder top()
 */
trait UserScope
{
    /**
     * Created today
     * @param $query
     * @return mixed
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Created today
     * @param $query
     * @return mixed
     */
    public function scopeStartOfMonth($query)
    {
        return $query->whereDate('created_at', '>=', Carbon::now()->startOfMonth());
    }

    /**
     * Users who most log in
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query
            ->select([
                $this->getTable() . '.*',
                DB::raw("(select count(*) from user_logs where user_id = " . $this->getTable()
                    . ".id and action = 'login') as cpt")
            ])
            ->orderBy('cpt', 'desc')
            ;
    }

    /**
     * Users grouped by themes
     * @param $query
     * @return mixed
     */
    public function scopeThemes($query)
    {
        return $query
            ->select([
                $this->getTable() . '.theme',
                DB::raw("count(*) as cpt")
            ])
            ->groupBy('theme')
            ->orderBy('cpt', 'desc')
            ;
    }

    /**
     * Patron users
     * @param $query
     * @return mixed
     */
    public function scopePatron($query)
    {
        return $query
            ->select($this->getTable() . '.*')
            ->join('user_roles as ur', 'ur.user_id', $this->getTable() . '.id')
            ->join('roles as r', 'r.id', 'ur.role_id')
            ->where('r.name', 'patreon');
    }

    /**
     * @param Builder $builder
     * @param array $options
     */
//    public function scopeFilter(Builder $query, array $options)
//    {
//        $valid = array('patreon_pledge');
//        foreach ($options as $option => $value) {
//            if (!in_array($option, $valid)) {
//                continue;
//            }
//
//            if (empty($value)) {
//                $query->where(function ($sub) use ($option) {
//                    $sub->whereNull($option)->orWhere($option, '');
//                });
//            } else {
//                $query->where($option, $value);
//            }
//        }
//    }
}
