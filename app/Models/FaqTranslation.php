<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Faq
 * @package App\Models
 *
 * @property int $id
 * @property int $faq_id
 * @property string $locale
 * @property string $question
 * @property string $answer
 * @property Faq $faq
 */
class FaqTranslation extends Model
{
    //public $table = 'faq_translations';


    public $fillable = [
        'faq_id',
        'question',
        'answer',
        'locale'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faq()
    {
        return $this->belongsTo('App\Models\Faq', 'faq_id', 'id');
    }

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
     * @param int $faq
     * @return Builder
     */
    public function scopeFaqID(Builder $query, int $faq): Builder
    {
        return $query->where('faq_id', $faq);
    }
}
