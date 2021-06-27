<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FaqCategory
 * @package App\Models
 *
 *
 * @property int $id
 * @property string $locale
 * @property string $title
 * @property int $order
 * @property bool $is_visible
 *
 * @property Faq[] $faqs
 */
class FaqCategory extends Model
{
    use Filterable, Sortable, Searchable;

    public $searchableColumns = ['name'];
    public $sortableColumns = [];
    public $filterableColumns = ['name'];

    public $fillable = [
        'title',
        'order',
        'is_visible',
        'locale'
    ];


    /**
     * @param $query
     * @param bool $visible
     * @return mixed
     */
    public function scopeVisible($query, $visible = true)
    {
        return $query->where('visible', $visible);
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
    public function faqs()
    {
        return $this->hasMany('App\Models\Faq', 'faq_category_id', 'id');
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function sortedFaqs()
    {
        return $this->faqs
            ->where('is_visible', true)
            ->sortBy('order');
    }
}
