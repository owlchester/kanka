<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
     * @param Builder $query
     * @param string $locale
     * @return Builder
     */
    public function scopeLocale(Builder $query, string $locale = 'en'): Builder
    {
        return $query->where('locale', $locale);
    }
    /**
     * @param Builder $query
     * @param int $category
     * @return Builder
     */
    public function scopeCategoryID(Builder $query, int $category): Builder
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
