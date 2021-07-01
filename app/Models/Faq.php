<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Faq
 * @package App\Models
 *
 * @property int $id
 * @property int $category_id
 * @property string $locale
 * @property string $question
 * @property string $answer
 */
class Faq extends Model
{
    public $table = 'faq';

    use  Orderable, Sortable, Filterable, Searchable;


    public $searchableColumns = ['question', 'answer'];
    public $sortableColumns = [];
    public $filterableColumns = ['question', 'answer'];

    public $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'order',
        'is_visible',
        'locale'
    ];

    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query;
    }

    /**
     * @param $query
     * @param bool $visible
     * @return mixed
     */
    public function scopeVisible($query, $visible = true)
    {
        return $query->where('is_visible', $visible);
    }

    /**
     * @param $query
     * @param string $locale
     * @return mixed
     */
    public function scopeLocale($query, $locale = 'en')
    {
        return $query->where('locale', $locale);
    }

    /**
     * @param $query
     * @param string $locale
     * @return mixed
     */
    public function scopeOrdered($query, $order = 'ASC')
    {
        return $query->orderBy('order', $order);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo('App\Models\FaqCategory', 'faq_category_id', 'id');
    }

    /**
     * @return string
     */
    public function slug()
    {
        return Str::slug($this->question);
    }

    public function scopeAdmin($query)
    {
        return $query;
    }
}
