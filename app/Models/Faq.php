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
 * @property FaqTranslation[] $translations
 * @property FaqTranslation $localeTranslation
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

    /** @var null|string Cached slug */
    protected $_slug = null;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
     * @return mixed
     */
    public function localeTranslation()
    {
        return $this->hasOne(FaqTranslation::class, 'faq_id', 'id')
            ->where('locale', app()->getLocale());
    }

    /**
     * @return string
     */
    public function slug(): string
    {
        if ($this->_slug !== null) {
            return $this->_slug;
        }
        return $this->_slug = Str::slug($this->question);
    }

    public function scopeAdmin($query)
    {
        return $query;
    }

    /**
     * Get the question
     * @return string
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
     * @return string
     */
    public function answer(): string
    {
        if ($this->localeTranslation && !empty($this->localeTranslation->answer)) {
            return $this->localeTranslation->answer;
        }
        return $this->answer;
    }

    public function translatedQuestion(string $locale): string
    {
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            return '';
        }

        return $translation->question;
    }
    public function translatedAnswer(string $locale): string
    {
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            return '';
        }

        return $translation->answer;
    }
}
