<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property FaqTranslation[]|Collection $translations
 * @property FaqTranslation|null $localeTranslation
 */
class Faq extends Model
{
    use Orderable;
    use Searchable;
    use Sortable;
    public $table = 'faq';


    public $searchableColumns = ['question', 'answer'];
    public $sortableColumns = [];

    public $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'order',
        'is_visible',
        'locale'
    ];

    /** @var null|string Cached slug */
    protected $cachedSlug = null;

    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query;
    }

    /**
     */
    public function scopeVisible(Builder $query, bool $visible = true): Builder
    {
        return $query->where('is_visible', $visible);
    }

    /**
     */
    public function scopeLocale(Builder $query, string $locale = 'en'): Builder
    {
        return $query->where('locale', $locale);
    }

    /**
     * @param string $order
     */
    public function scopeOrdered(Builder $query, $order = 'ASC'): Builder
    {
        return $query->orderBy('order', $order);
    }

    /**
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\FaqCategory', 'faq_category_id', 'id');
    }

    /**
     */
    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
     */
    public function localeTranslation()
    {
        return $this->hasOne(FaqTranslation::class, 'faq_id', 'id')
            ->where('locale', app()->getLocale());
    }

    /**
     */
    public function slug(): string
    {
        if ($this->cachedSlug !== null) {
            return $this->cachedSlug;
        }
        return $this->cachedSlug = Str::slug($this->question);
    }

    /**
     * Get the question
     */
    public function question(): string
    {
        if ($this->localeTranslation && !empty($this->localeTranslation->question)) {
            return $this->localeTranslation->question;
        }
        return $this->question;
    }

    /**
     * Get the answer
     */
    public function answer(): string
    {
        if ($this->localeTranslation && !empty($this->localeTranslation->answer)) {
            return $this->localeTranslation->answer;
        }
        return $this->answer;
    }

    /**
     */
    public function translatedQuestion(string $locale): string
    {
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            return '';
        }

        return $translation->question;
    }

    /**
     */
    public function translatedAnswer(string $locale): string
    {
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            return '';
        }

        return $translation->answer;
    }
}
