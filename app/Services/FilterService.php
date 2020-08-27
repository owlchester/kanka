<?php

namespace App\Services;

use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FilterService
{
    /**
     * The filters as saved in the session
     * @var array
     */
    protected $filters = [];

    /**
     * The order as saved in the session
     * @var array
     */
    protected $order = [];

    /**
     * The request data
     * @var array
     */
    protected $data = [];

    /**
     * The index crud for session keys
     * @var string
     */
    protected $crud = '';

    /**
     * Search option
     * @var string
     */
    protected $search = '';

    /**
     * @param string $crud
     * @param array $requestData
     * @param Model $model
     * @throws \Exception
     */
    public function make(string $crud, array $requestData, Model $model)
    {
        $this->data = $requestData;
        $this->crud = $crud;

        if (!method_exists($model, 'getFilterableColumns')) {
            throw new \Exception('Model ' . $model . ' doesn\'t implement the Filterable trait.');
        }
        $this->prepareFilters($model->getFilterableColumns())
            ->prepareOrder($model->sortableColumns())
            ->prepareSearch();
    }

    /**
     * Prepare the filters
     * @param array $availableFilters
     * @return self
     */
    protected function prepareFilters($availableFilters = []): self
    {
        // No point in doing any work if the model has no fields to filter.
        if (empty($availableFilters)) {
            return $this;
        }

        $sessionKey = 'filterService-filter-' . $this->crud;

        if (request()->get('_from', false) == 'quicklink') {
            $sessionKey .= '-quicklink';
        }
        $this->filters = session()->get($sessionKey);

        // If the request has _clean, we only want filters that are set in the url
        if (request()->get('_clean', false)) {
            $this->filters = [];
        }

        // If we have data but no "tags" array, it's empty
        if (!empty($this->data) && in_array('tags', $availableFilters) && !isset($this->data['tags'])) {
            // Not calling from a page or order result, we can junk the filters
            if (empty($this->data['page']) && empty($this->data['order'])) {
                $this->data['tags'] = null;
            }
        }

        foreach ($this->data as $key => $value) {
            if (in_array($key, $availableFilters)) {
                // Update the value we have in the session.
                $this->filters[$key] = $value;
                continue;
            }

            // Of if it's the _option of a filter
            if (Str::endsWith($key, '_option')) {
                $stripedKey = Str::before($key, '_option');
                if (in_array($stripedKey, $availableFilters)) {
                    // Update the value we have in the session.
                    $this->filters[$key] = $value;
                    continue;
                }
            }

        }

        // Foreign keys that are not set might have been cleared. If so, remove them from the filters.
        // However only do this if not ordering or changing pages
        if (!empty($this->data) && !array_key_exists('order', $this->data) && !array_key_exists('page', $this->data)) {
            foreach ($availableFilters as $filter) {
                if (!isset($this->data[$filter]) && Str::endsWith($filter, '_id')) {
                    $this->filters[$filter] = null;
                }
            }
        }

        // Reset the filters if requested, before saving it to the session.
        if (Arr::has($this->data, 'reset-filter')) {
            $this->filters = [];
        }

        // Save the new data into the session
        session()->put($sessionKey, $this->filters);
        return $this;
    }

    /**
     * Prepare the Order By data
     * @property array $availableFields
     * @return self
     */
    protected function prepareOrder(array $availableFields = []): self
    {
        // Get all of the posted data. We need to see if any of it is part of a filter.
        $field = Arr::get($this->data, 'order');
        $direction = Arr::get($this->data, 'desc');

        $sessionKey = 'filterService-order-' . $this->crud;
        $this->order = session()->get($sessionKey);

        if (!empty($field)) {
            $this->order = [
                $field => empty($direction) ? 'ASC' : 'DESC'
            ];

            if (!in_array($field, $availableFields)) {
                $this->order = [];
            }
        }

        // Reset the filters if requested, before saving it to the session.
        if (Arr::has($this->data, 'reset-filter')) {
            $this->order = [];
        }

        // Save the new data into the session
        session()->put($sessionKey, $this->order);
        return $this;
    }

    /**
     * @return $this
     */
    private function prepareSearch(): self
    {
        $search = Arr::get($this->data, 'search');
        $this->search = strip_tags($search);
        return $this;
    }

    /**
     * @param $key
     * @param null $default
     * @return array|\Illuminate\Contracts\Translation\Translator|mixed|string|null
     * @throws \Exception
     */
    public function single($key, $default = null)
    {
        if (is_array($key)) {
            throw new \Exception('Key for FilterService can\'t be an array');
        }
        if (!empty($this->filters) && isset($this->filters[$key])) {
            if ($this->isCheckbox($key)) {
                return $this->filters[$key] == '1' ? trans('voyager.generic.yes') : trans('voyager.generic.no');
            }
            return $this->filters[$key];
        }
        return $default;
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     * @throws \Exception
     */
    public function filterValue($key, $default = null)
    {
        if (is_array($key)) {
            throw new \Exception('Key for FilterService can\'t be an array');
        }
        if (!empty($this->filters) && isset($this->filters[$key])) {
            return $this->filters[$key];
        }
        return $default;
    }

    /**
     * Get the filters
     * @return array
     */
    public function filters()
    {
        return $this->filters;
    }

    /**
     * Get the order data
     * @return null
     */
    public function order()
    {
        return $this->order;
    }

    /**
     * Get the search data
     * @return null
     */
    public function search()
    {
        return $this->search;
    }

    /**
     * @param $field
     * @return bool
     */
    public function isCheckbox($field)
    {
        return Str::startsWith($field, ['is_', 'has_']);
    }

    /**
     * @return array
     */
    public function activeFilters(): array
    {
        if (empty($this->filters)) {
            return [];
        }

        $filters = [];
        foreach ($this->filters as $key => $val) {
            if ($val !== null) {
                $filters[$key] = $val;
            }
        }
        return $filters;
    }

    /**
     * @return int
     */
    public function activeFiltersCount(): int
    {
        return count($this->activeFilters());
    }

    /**
     * @return bool
     */
    public function hasFilters(): bool
    {
        return !empty($this->filters);
    }

    /**
     * Prepare data to append to the crud pagination
     * @return array
     */
    public function pagination(): array
    {
        $options = [];
        if (!empty($this->search)) {
            $options['search'] = $this->search;
        }

        if (request()->get('_from', false) == 'quicklink') {
            $options['_from'] = 'quicklink';
        }


        return $options;
    }
}
