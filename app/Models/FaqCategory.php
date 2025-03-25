<?php

namespace App\Models;

use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class FaqCategory
 *
 *
 * @property int $id
 * @property string $locale
 * @property string $title
 * @property int $order
 * @property bool|int $is_visible
 * @property Faq[]|Collection $faqs
 */
class FaqCategory extends Model
{
    use Searchable;
    use Sortable;

    public $searchableColumns = ['name'];

    public $sortableColumns = [];

    public $fillable = [
        'title',
        'order',
        'is_visible',
        'locale',
    ];

    protected $_locale;

    protected $_faqCount = false;

    /**
     * @param  bool  $visible
     */
    public function scopeVisible(Builder $query, $visible = true)
    {
        return $query->where('is_visible', $visible);
    }

    /**
     * @param  string  $locale
     */
    public function scopeLocale(Builder $query, $locale = 'en')
    {
        return $query->where('locale', $locale);
    }

    /**
     * @param  string  $order
     * @return Builder
     */
    public function scopeOrdered(Builder $query, $order = 'ASC')
    {
        return $query->orderBy('order', $order);
    }

    public function faqs(): HasMany
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
     * @return Faq[]|Collection
     */
    public function sortedFaqs()
    {
        return $this->faqs
            ->where('is_visible', true)
            ->sortBy('order');
    }

    public function faqCount()
    {
        if ($this->_faqCount === false) {
            $this->_faqCount = $this->faqs->count();
        }

        return $this->_faqCount;
    }
}
