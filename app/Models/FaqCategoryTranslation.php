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
 * @property int $faq_category_id
 * @property string $locale
 * @property string $title
 * @property bool $is_visible
 *
 * @property FaqCategory $category
 */
class FaqCategoryTranslation extends Model
{
    public $fillable = [
        'title',
        'locale',
        'faq_category_id',
    ];

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
    public function scopeCategoryID($query, int $category)
    {
        return $query->where('faq_category_id', $category);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\FaqCategory', 'faq_category_id', 'id');
    }
}
