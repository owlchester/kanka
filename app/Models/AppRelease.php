<?php


namespace App\Models;


use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppRelease
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $excerpt
 * @property string $link
 * @property Carbon $published_at
 * @property int $created_by
 * @property User $author
 */
class AppRelease extends Model
{
    use Filterable, Sortable, Searchable;

    public $table = 'releases';

    public $dates = [
        'published_at',
    ];

    public $searchableColumns = ['name'];
    public $sortableColumns = [];
    public $filterableColumns = ['name'];

    public $fillable = [
        'name',
        'link',
        'excerpt',
        'published_at',
        'created_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
