<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\Mentions;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TimelineEra
 *
 * @property int $id
 * @property ?int $timeline_id
 * @property string $name
 * @property string $entry
 * @property string $abbreviation
 * @property string|int $start_year
 * @property string|int $end_year
 * @property bool|int $is_collapsed
 * @property ?int $position
 * @property Timeline $timeline
 * @property TimelineElement[]|Collection $elements
 * @property TimelineElement[]|Collection $orderedElements
 *
 * @method static self|Builder ordered()
 */
class TimelineEra extends Model
{
    use HasEntry;
    use HasFactory;
    use Sanitizable;
    use SortableTrait;

    protected $fillable = [
        'timeline_id',
        'name',
        'abbreviation',
        'entry',
        'start_year',
        'end_year',
        'is_collapsed',
    ];

    protected array $sortable = [
        'name',
        'position',
        'abbreviation',
        'start_year',
        'end_year',
        'is_collapsed',
    ];

    protected array $sanitizable = [
        'name',
        'abbreviation',
        'start_year',
        'end_year',
    ];

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    public function elements(): HasMany
    {
        return $this->hasMany(TimelineElement::class, 'era_id');
    }

    public function orderedElements(): HasMany
    {
        return $this->elements()
            ->ordered();
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('position')
            ->orderBy('start_year')
            ->orderBy('end_year')
            ->orderBy('name');
    }

    public function collapsed(): bool
    {
        return $this->is_collapsed;
    }

    /**
     * Get the age header of the era
     */
    public function ages(): string
    {
        $a = new \NumberFormatter(app()->getLocale(), \NumberFormatter::DECIMAL);
        $from = mb_strlen($this->start_year);
        $to = mb_strlen($this->end_year);

        if ($from == 0 && $to == 0) {
            return '';
        }

        if ($from == 0) {
            return '< ' . $a->format($this->start_year);
        } elseif ($to == 0) {
            return '> ' . $a->format($this->start_year);
        }

        return $a->format($this->start_year) . ' &mdash; ' . $a->format($this->end_year);
    }

    public function hasEntity(): bool
    {
        return false;
    }

    /**
     * Functions for the datagrid2
     */
    public function url(string $where): string
    {
        return 'timelines.timeline_eras.' . $where;
    }

    public function routeParams(array $options = []): array
    {
        return $options + ['timeline' => $this->timeline_id, 'timeline_era' => $this->id];
    }

    /**
     * Override the get link
     */
    public function getLink(): string
    {
        $campaign = CampaignLocalization::getCampaign();

        return route('timelines.timeline_eras.edit', [$campaign, 'timeline' => $this->timeline_id, $this->id]);
    }

    public function getEntryForEditionAttribute()
    {
        $text = Mentions::parseForEdit($this);

        return $text;
    }

    /**
     * @return array|string[]
     */
    public function positionOptions($position = null, bool $new = false): array
    {
        $options = [null => __('posts.position.dont_change')];

        $elements = $this->orderedElements;
        $hasFirst = false;
        foreach ($elements as $element) {
            if (! $element->visible()) {
                continue;
            }
            if (! $hasFirst) {
                $hasFirst = true;
                $options[1] = __('posts.position.first');
            }
            $key = $element->position;
            $lang = __('maps/layers.placeholders.position_list', ['name' => $element->elementName()]);
            if (config('app.debug')) {
                $lang .= ' (' . $key . ')';
            }
            if (! ($position == $key)) {
                $options[$key + 1] = $lang;
            }
        }

        // Didn't have a first option added, add one now
        if (! $hasFirst) {
            $options[1] = __('posts.position.first');
        }

        if ($new) {
            unset($options[null]);
        }

        return $options;
    }
}
