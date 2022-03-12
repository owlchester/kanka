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
 * @property FaqCategoryTranslation[] $translations
 * @property FaqCategoryTranslation $localeTranslation
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

    protected $_locale;
    protected $_faqCount = false;
    protected $_translatedCount = false;


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
    public function faqs()
    {
        return $this->hasMany('App\Models\Faq', 'faq_category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany('App\Models\FaqCategoryTranslation', 'faq_category_id', 'id');
    }

    /**
     * @return mixed
     */
    public function localeTranslation()
    {
        return $this->hasOne(FaqCategoryTranslation::class, 'faq_category_id', 'id')
            ->where('locale', app()->getLocale());
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->title;
    }

    /**
     * @return Faq[]
     */
    public function sortedFaqs()
    {
        return $this->faqs
            ->where('is_visible', true)
            ->sortBy('order');
    }

    /**
     * Get the title (translated if available)
     * @return string
     */
    public function title(): string
    {
        if ($this->localeTranslation && !empty($this->localeTranslation->title)) {
            return $this->localeTranslation->title;
        }
        return $this->title;
    }

    /**
     * @param string $locale
     * @return string
     */
    public function translatedTitle(string $locale): string
    {
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            return '';
        }

        return $translation->title;
    }

    /**
     * @param string $locale
     * @return bool
     */
    public function untranslated(string $locale): bool
    {
        return $this->faqCount()<> $this->translatedCount($locale);
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function translatedCount($locale)
    {
        if ($this->_translatedCount === false) {
            $ids = $this->faqs->pluck('id')->toArray();
            $this->_translatedCount = FaqTranslation::locale($locale)->whereIn('faq_id', $ids)->count();;
        }
        return $this->_translatedCount;
    }

    /**
     * @return mixed
     */
    public function faqCount()
    {
        if ($this->_faqCount === false) {
            $this->_faqCount = $this->faqs->count();
        }
        return $this->_faqCount;
    }
}
