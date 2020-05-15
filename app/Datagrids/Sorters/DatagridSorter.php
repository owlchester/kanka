<?php

namespace App\Datagrids\Sorters;

use App\Models\Campaign;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class DatagridSorter
{
    /**
     * @var array
     */
    public $options;

    /**
     * The default field for sorting
     * @var string|array
     */
    public $default = 'name';

    /**
     * The default order
     * @var string
     */
    public $order = 'asc';

    /**
     * The current selected option
     * @var string
     */
    public $selected = '';

    /**
     * Field name for the request key
     * @var string
     */
    protected $fieldname = 'dg-sort';

    /**
     * The column to order by
     * @var string
     */
    protected $column = '';

    /**
     * @var bool|string
     */
    protected $sessionKey = false;

    /**
     * Casting of ints for order by (ex age)
     * @var array
     */
    public $orderCasting = [];

    /**
     * Raw operations for order by (ex age)
     * @var array
     */
    public $orderRaw = [];

    /**
     * Sort options where one field orders several behind the scenes (typically for dates)
     * @var array
     */
    public $orderMultiple = [];

    /**
     * DatagridSorter constructor.
     */
    public function __construct()
    {
        $session = session()->get($this->sessionkey());
        if (!empty($session)) {
            $this->parse($session);
        }
    }

    /**
     * Build the list of filters
     * @param Campaign|null $campaign
     * @return array
     */
    public function options(Campaign $campaign = null): array
    {
        // Clean up options that don't make sense for this campaign
        $options = [];
        foreach ($this->options as $key => $option) {
            if ($this->validOption($key, $campaign)) {
                $options[$key] = $option;
            }
        }
        return $options;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isSelected(string $key, bool $asc = true): bool
    {
        $key .= $this->direction($asc);
        return $this->selected === $key;
    }

    /**
     * Get the direction part of the key
     * @param bool $asc
     * @return string
     */
    public function direction(bool $asc = true): string
    {
        return $asc ? '_asc' : '_desc';
    }

    /**
     * @return string
     */
    public function fieldname(): string
    {
        return $this->fieldname;
    }

    /**
     * @param array $data
     * @return DatagridSorter
     */
    public function request(array $data): self
    {
        $selected = strtolower(Arr::get($data, $this->fieldname()));
        $segments = explode('_', $selected);
        if (count($segments) < 2) {
            return $this;
        }
        $this->parse($selected);

        // Save these new values in the session
        session()->put($this->sessionkey(), $this->selected);

        return $this;
    }

    /**
     * The field to perform the order by on
     * @return string|array
     */
    public function column()
    {
        if (!empty($this->column)) {
            return $this->column;
        }

        return $this->default;
    }

    /**
     * @param string $column
     * @return bool
     */
    public function hasOrderCasting(string $column): bool
    {
        return isset($this->orderCasting[$column]);
    }

    /**
     * @param string $column
     * @return mixed
     */
    public function orderCasting(string $column)
    {
        return Arr::get($this->orderCasting, $column, null);
    }

    /**
     * @param string $column
     * @return bool
     */
    public function hasOrderRaw(string $column): bool
    {
        return isset($this->orderRaw[$column]);
    }

    /**
     * @param string $column
     * @return mixed
     */
    public function orderRaw(string $column)
    {
        return Arr::get($this->orderRaw, $column, null);
    }


    /**
     * @param string $column
     * @return bool
     */
    public function hasMultipleOrder(string $column): bool
    {
        return isset($this->orderMultiple[$column]);
    }

    /**
     * @param string $column
     * @return array
     */
    public function orderMultiple(string $column)
    {
        return Arr::get($this->orderMultiple, $column, []);
    }

    /**
     * @return string
     */
    public function order(): string
    {
        return (string) $this->order;
    }

    /**
     * @return string
     */
    protected function sessionkey(): string
    {
        // ReflectionClass is cheap but let's still avoid extra calls
        if ($this->sessionKey === false) {
            $this->sessionKey = 'dg-sorter-' . Str::kebab((new \ReflectionClass($this))->getShortName());
        }
        return $this->sessionKey;
    }

    /**
     * @param string $selected
     * @return DatagridSorter
     */
    protected function parse(string $selected): self
    {
        $this->selected = $selected;

        // Handle order later
        $segments = explode('_', $selected);
        $order = array_pop($segments);


        // Validate fields. We can have "abc_asc" and "other.is_abs_desc" as fields
        $field = implode('_', $segments);
        if (in_array($field, array_keys($this->options))) {
            $this->column = $field;
        }

        // Validate order
        if (!empty($order) && in_array($order, ['asc', 'desc'])) {
            $this->order = $order;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param Campaign|null $campaign
     */
    protected function validOption(string $key, Campaign $campaign = null)
    {
        $whitelist = ['tag.name', 'target.name'];
        if (strpos($key, '.name') === false || in_array($key, $whitelist)) {
            return true;
        }
        if ($key == 'entity.name') {
            return true;
        }

        // If it's a foreign key, it can probably be a module
        $module = str_replace('.name', '', $key);
        $module = Str::plural($module);

        return $campaign->enabled($module);
    }
}
