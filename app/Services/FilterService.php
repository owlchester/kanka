<?php

namespace App\Services;

use App\Models\Location;
use App\Models\MiscModel;
use App\Traits\EntityTypeAware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FilterService
{
    use EntityTypeAware;

    /** @var array The filters as saved in the session */
    protected array $filters = [];

    /** @var array|null The order as saved in the session */
    protected ?array $order = [];

    /** @var array The request data */
    protected array $data = [];

    /** @var string The index crud for session keys */
    protected string $crud = '';

    /** @var string Search option */
    protected string $search = '';

    /** @var bool If the filters are stored in the session */
    protected bool $session = true;

    /** @var Request The request object */
    protected Request $request;

    protected bool $hasRequest = false;

    /** @var Model|MiscModel|Location The entity sub model */
    protected Model|MiscModel|Location $model;

    public function request(Request $request): self
    {
        $this->request = $request;
        $this->data = $request->all();
        $this->hasRequest = true;

        return $this;
    }

    public function options(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function model(Model $model): self
    {
        if (! method_exists($model, 'getFilterableColumns')) {
            throw new \Exception('Model ' . $model . ' doesn\'t implement the Filterable trait.');
        }
        $this->model = $model;

        return $this;
    }

    public function build()
    {
        $this->crud = $this->entityType->code;

        $this->prepareFilters([
            'name',
            'type',
            'is_private',
            'template',
            'tag_id',
            'tags',
            'has_image',
            'has_posts',
            'has_entry',
            'has_entity_files',
            'has_attributes',
            'created_by',
            'updated_by',
            'attribute_name',
            'attribute_value',
            'archived',
        ])
            ->prepareOrder(['name', 'type', 'is_private'])
            ->prepareSearch();
    }

    public function make(string $crud)
    {
        $this->crud = $crud;

        $this->prepareFilters($this->model->getFilterableColumns()) // @phpstan-ignore-line
            ->prepareOrder($this->model->sortableColumns()) // @phpstan-ignore-line
            ->prepareSearch();
    }

    /**
     * Prepare the filters
     */
    protected function prepareFilters(array $availableFilters = []): self
    {
        // No point in doing any work if the model has no fields to filter.
        if (empty($availableFilters)) {
            return $this;
        }

        // Load the filters from the session if we're revisiting a page
        $sessionKey = 'filterService-filter-' . $this->crud;
        if ($this->hasRequest && $this->request->get('_from', false) == 'bookmark') {
            $sessionKey .= '-bookmark';
        }
        $this->filters = $this->sessionLoad($sessionKey);

        // If the request has _clean, we only want filters that are set in the url
        if ($this->hasRequest && $this->request->get('_clean', false)) {
            $this->filters = [];
        }

        foreach (['tags', 'locations', 'organisations', 'races', 'families'] as $key) {
            $this->checkFilterData($key, $availableFilters);
        }

        // If we have data but no "tags" array, it's empty
        if (! empty($this->data) && in_array('tags', $availableFilters) && ! isset($this->data['tags'])) {
            // Not calling from a page or order result, we can junk the filters
            if (empty($this->data['page']) && empty($this->data['order'])) {
                unset($this->data['tags']);
            }
        }
        // If we have data but no "locations" array, it's empty
        if (! empty($this->data) && in_array('locations', $availableFilters) && ! isset($this->data['locations'])) {
            // Not calling from a page or order result, we can junk the filters
            if (empty($this->data['page']) && empty($this->data['order'])) {
                unset($this->data['locations']);
            }
        }

        // If we have data but no "organisations" array, it's empty
        if (! empty($this->data) && in_array('organisations', $availableFilters) && ! isset($this->data['organisations'])) {
            // Not calling from a page or order result, we can junk the filters
            if (empty($this->data['page']) && empty($this->data['order'])) {
                unset($this->data['organisations']);
            }
        }

        // If we have data but no "races" array, it's empty
        if (! empty($this->data) && in_array('races', $availableFilters) && ! isset($this->data['races'])) {
            // Not calling from a page or order result, we can junk the filters
            if (empty($this->data['page']) && empty($this->data['order'])) {
                unset($this->data['races']);
            }
        }

        // If we have data but no "families" array, it's empty
        if (! empty($this->data) && in_array('families', $availableFilters) && ! isset($this->data['families'])) {
            // Not calling from a page or order result, we can junk the filters
            if (empty($this->data['page']) && empty($this->data['order'])) {
                unset($this->data['families']);
            }
        }

        // Don't support the old tags, force using tags[]
        if (isset($this->data['tags']) && ! is_array($this->data['tags'])) {
            unset($this->data['tags']);
        }

        foreach ($this->data as $key => $value) {
            if (in_array($key, $availableFilters)) {
                // Update the value we have in the session.
                // But skip empty arrays (typically when sending `families[]=`
                if ($value === [0 => null]) {
                    $value = null;
                }
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
        // However, only do this if not ordering or changing pages
        if (! empty($this->data) && ! array_key_exists('order', $this->data) && ! array_key_exists('page', $this->data)) {
            foreach ($availableFilters as $filter) {
                if (! isset($this->data[$filter]) && Str::endsWith($filter, '_id')) {
                    $this->filters[$filter] = null;
                }
            }
        }

        // Reset the filters if requested, before saving it to the session.
        if (Arr::has($this->data, 'reset-filter')) {
            $this->filters = [];
        }

        // Save the new data into the session
        $this->sessionSave($sessionKey, $this->filters);

        return $this;
    }

    /**
     * Prepare the Order By data
     *
     * @property array $availableFields
     */
    protected function prepareOrder(array $availableFields = []): self
    {
        // Get all the posted data. We need to see if any of it is part of a filter.
        $field = Arr::get($this->data, 'order');
        $direction = Arr::get($this->data, 'desc');

        $sessionKey = 'filterService-order-' . $this->crud;
        $this->order = session()->get($sessionKey, []);
        if ($this->order === null) {
            $this->order = [];
        }

        if (! empty($field) && is_string($field)) {
            $this->order = [
                $field => empty($direction) ? 'ASC' : 'DESC',
            ];

            if (! in_array($field, $availableFields)) {
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

    private function checkFilterData(string $key, array $availableFilters): void
    {
        // If we have data but no array, it's empty
        if (! empty($this->data) && in_array($key, $availableFilters) && ! isset($this->data[$key])) {
            // Not calling from a page or order result, we can junk the filters
            if (empty($this->data['page']) && empty($this->data['order'])) {
                unset($this->data[$key]);
            }
        }
    }

    private function prepareSearch(): self
    {
        $search = Arr::get($this->data, 'search');
        $this->search = $search ? strip_tags($search) : '';

        return $this;
    }

    /**
     * @param  string|array  $key
     * @return array|\Illuminate\Contracts\Translation\Translator|mixed|string|null
     *
     * @throws \Exception
     */
    public function single(mixed $key, ?string $default = null)
    {
        if (is_array($key)) {
            throw new \Exception('Key for FilterService can\'t be an array');
        }
        if (! empty($this->filters) && isset($this->filters[$key])) {
            if ($this->isCheckbox($key)) {
                return $this->filters[$key] == '1' ? __('general.yes') : __('general.no');
            }
            $result = $this->filters[$key];

            return is_array($result) ? $default : $result;
        }

        return $default;
    }

    /**
     * @param  string|array  $key
     *
     * @throws \Exception
     */
    public function filterValue(mixed $key, ?string $default = null)
    {
        if (is_array($key)) {
            throw new \Exception('Key for FilterService can\'t be an array');
        }
        if (! empty($this->filters) && isset($this->filters[$key])) {
            return $this->filters[$key];
        }

        return $default;
    }

    /**
     * Get the filters
     */
    public function filters(): array
    {
        return $this->filters;
    }

    /**
     * Get the order data
     */
    public function order(): array
    {
        return $this->order;
    }

    /**
     * Get the search data
     */
    public function search(): string
    {
        return $this->search;
    }

    /**
     * Determine if a filter is a checkbox
     */
    public function isCheckbox(string $field): bool
    {
        return Str::startsWith($field, ['is_', 'has_']);
    }

    /**
     * Get the active filters
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

    public function activeFiltersCount(): int
    {
        return count($this->activeFilters());
    }

    /**
     * Determine if the request has active filters
     */
    public function hasFilters(): bool
    {
        return $this->activeFiltersCount() > 0;
    }

    /**
     * Prepare data to append to the crud pagination
     */
    public function pagination(): array
    {
        $options = [];
        if (! empty($this->search)) {
            $options['search'] = $this->search;
        }

        if (! $this->hasRequest) {
            return $options;
        }

        if ($this->request->get('_from', false) == 'bookmark') {
            $options['_from'] = 'bookmark';
        }

        if ($bookmarkId = $this->request->get('bookmark')) {
            $options['bookmark'] = (int) $bookmarkId;
        }

        if ($this->request->filled('parent_id')) {
            $options['parent_id'] = (int) $this->request->get('parent_id');
        }

        return $options;
    }

    /**
     * Flag the service to save the filters in session
     */
    public function session(bool $session = true): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Load the stored filter data from session
     */
    protected function sessionLoad(string $key): array
    {
        if (! $this->session) {
            return [];
        }

        if (! session()->has($key)) {
            return [];
        }

        return session()->get($key);
    }

    /**
     * Save the filter data to the session
     */
    protected function sessionSave(string $key, $data): self
    {
        if (! $this->session) {
            return $this;
        }

        session()->put($key, $data);

        return $this;
    }

    /**
     * Prepare filters to be copied to the clipboard
     */
    public function clipboardFilters(): string
    {
        $filters = [];
        foreach ($this->filters as $key => $val) {
            if ($val !== null) {
                if (! is_array($val)) {
                    $filters[] = $key . '=' . $val;

                    continue;
                }

                foreach ($val as $arrValue) {
                    // If it's an array in an array, we don't support it.
                    // For example calling the page with tags[bla][bli][blo]
                    if (is_array($arrValue)) {
                        continue;
                    }
                    $filters[] = $key . '[]=' . $arrValue;
                }
            }
        }

        return (string) implode('&', $filters);
    }
}
