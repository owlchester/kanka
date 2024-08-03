<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function faq(): BelongsTo
    {
        return $this->belongsTo('App\Models\Faq', 'faq_id', 'id');
    }

    /**
     */
    public function scopeLocale(Builder $query, string $locale = 'en'): Builder
    {
        return $query->where('locale', $locale);
    }

    /**
     */
    public function scopeFaqID(Builder $query, int $faq): Builder
    {
        return $query->where('faq_id', $faq);
    }
}
