<?php

namespace App\Services;

use App\Models\MiscModel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class FilterService
{
//    /**
//     * @var Request
//     */
//    protected $request;
//
//    /**
//     * @var Session
//     */
//    protected $session;
//
//    /**
//     * FilterService constructor.
//     * @param Request $request
//     * @param Session $session
//     */
//    public function __construct(Request $request, Session $session)
//    {
//        $this->request = $request;
//        $this->session = $session;
//    }

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
     * @param $crud
     * @param array $requestData
     * @param array $availableFilters
     */
    public function prepare($crud, $requestData = [], $availableFilters = [])
    {
        $this->data = $requestData;
        $this->prepareFilters($crud, $availableFilters);
        $this->prepareOrder($crud);
    }

    /**
     * Prepare the filters
     * @param string $crud
     * @param array $availableFilters
     * @return array
     */
    protected function prepareFilters($crud, $availableFilters = [])
    {
        // No point in doing any work if the model has no fields to filter.
        if (empty($availableFilters)) {
            return [];
        }

        $sessionKey = 'filterService-filter-' . $crud;
        $this->filters = session()->get($sessionKey);

        foreach ($this->data as $key => $value) {
            if (in_array($key, $availableFilters)) {
                // Update the value we have in the session.
                $this->filters[$key] = $value;
            }
        }

        // Checkbox? If no request but it's post, we don't have it anymore
        if (request()->isMethod('get') && !empty($this->filters)) {
            foreach ($this->filters as $key => $value) {
                if (strpos($key, 'is_') !== false && !isset($this->data[$key])) {
                    unset($this->filters[$key]);
                }
            }
        }

        // Reset the filters if requested, before saving it to the session.
        if (array_has($this->data, 'reset-filter')) {
            $this->filters = [];
        }

        // Save the new data into the session
        session()->put($sessionKey, $this->filters);
        return $this->filters;
    }

    /**
     * Prepare the Order By data
     * @param $crud
     * @return array
     */
    protected function prepareOrder($crud)
    {
        // Get all of the posted data. We need to see if any of it is part of a filter.
        $field = array_get($this->data, 'order');
        $direction = array_get($this->data, 'desc');

        $sessionKey = 'filterService-order-' . $crud;
        $this->order = session()->get($sessionKey);

        if (!empty($field)) {
            $this->order = [
                $field => empty($direction) ? 'ASC' : 'DESC'
            ];
        }

        // Reset the filters if requested, before saving it to the session.
        if (array_has($this->data, 'reset-filter')) {
            $this->order = [];
        }

        // Save the new data into the session
        session()->put($sessionKey, $this->order);
        return $this->order;
    }

    /**
     * @param $key
     * @return mixed|null
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
     * @param $field
     * @return bool
     */
    public function isCheckbox($field)
    {
        return strpos($field, 'is_') !== false;
    }

    /**
     * @return int
     */
    public function activeFilters()
    {
        if (empty($this->filters)) {
            return 0;
        }

        $count = 0;
        foreach($this->filters as $key => $val) {
            if ($val !== null) {
                $count++;
            }
        }
        return $count;
    }
}
