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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faq()
    {
        return $this->belongsTo('App\Models\Faq', 'faq_id', 'id');
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
    public function scopeFaqID($query, int $faq)
    {
        return $query->where('faq_id', $faq);
    }

}
