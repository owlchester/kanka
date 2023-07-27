<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class CampaignStyle
 * @package App\Models
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $created_by
 * @property string $name
 * @property string $content
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property bool $is_enabled
 * @property bool $is_theme
 * @property int $order
 *
 * @method static self|Builder enabled($enabled = true)
 */
class CampaignStyle extends Model
{
    use CampaignTrait;
    use SoftDeletes;
    use SortableTrait;

    public $fillable = [
        'name',
        'content',
        'is_enabled',
        'order',
    ];

    public $sortable = [
        'name',
        'updated_at',
        'is_enabled',
        'order',
        'is_theme',
    ];

    public $defaultSort = ['order', 'id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    /**
     * @param Builder $query
     * @param bool $enabled
     * @return Builder
     */
    public function scopeEnabled(Builder $query, bool $enabled = true)
    {
        return $query->where('is_enabled', $enabled);
    }

    /**
     * @param Builder $query
     * @param bool $theme
     * @return Builder
     */
    public function scopeTheme(Builder $query, bool $theme = true)
    {
        return $query->where('is_theme', $theme);
    }

    /**
     * @return string
     */
    public function length(): string
    {
        return (string) number_format(mb_strlen($this->content));
    }

    /**
     * @param string $sub
     * @return string
     */
    public function url(string $sub): string
    {
        return 'campaign_styles.' . $sub;
    }

    public function isTheme(): bool
    {
        return $this->is_theme;
    }


    public function content(): string|null
    {
        if (!$this->isTheme()) {
            return $this->content;
        }

        try {
            $theme = [':root {'];
            $config = json_decode($this->content);
            foreach ($config as $k => $v) {
                $theme[] = '  --' . $k . ': ' . $v . ';';
            }
            $theme[] = '}';
            return implode("\n", $theme);
        } catch (Exception $e) {
            return '/** Issue with the theme, please contact us */' . "\n\n";
        }
    }

    public function jsonConfig(): string
    {
        if (empty($this->content)) {
            return '';
        }

        $rootless = Str::remove([':root ', "\n"], $this->content);

        $json = json_encode($rootless);
        dd($json);
    }
}
