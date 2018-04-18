<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
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
}
