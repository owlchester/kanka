<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Observers\CampaignStyleObserver;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class CampaignStyle
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property bool|int $is_enabled
 * @property bool|int $is_theme
 * @property int $order
 *
 * @method static self|Builder enabled($enabled = true)
 */
class CampaignStyle extends Model
{
    use Blameable;
    use HasCampaign;
    use HasFactory;
    use Sanitizable;
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

    protected array $sanitizable = [
        'name',
    ];

    public $defaultSort = ['order', 'id'];

    protected static function booted()
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }
        static::observe(CampaignStyleObserver::class);
    }

    public function scopeEnabled(Builder $query, bool $enabled = true): Builder
    {
        return $query->where('is_enabled', $enabled);
    }

    public function scopeTheme(Builder $query, bool $theme = true): Builder
    {
        return $query->where('is_theme', $theme);
    }

    public function length(): string
    {
        return (string) number_format(mb_strlen($this->content));
    }

    public function url(string $sub): string
    {
        return 'campaign_styles.' . $sub;
    }

    public function isTheme(): bool
    {
        return $this->is_theme;
    }

    public function content(): ?string
    {
        if (! $this->isTheme()) {
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
