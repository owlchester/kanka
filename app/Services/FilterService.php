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
     * @param $crud
     * @param array $availableFilters
     * @return array|mixed
     */
    public function filter($crud, $availableFilters = [])
    {
        // No point in doing any work if the model has no fields to filter.
        if (empty($availableFilters)) {
            return [];
        }

        // Get all of the posted data. We need to see if any of it is part of a filter.
        $data = request()->all();

        $sessionKey = 'filterService-' . $crud;
        $this->filters = session()->get($sessionKey);

        foreach ($data as $key => $value) {
            if (in_array($key, $availableFilters)) {
                // Update the value we have in the session.
                $this->filters[$key] = $value;
            }
        }

        // Reset the filters if requested, before saving it to the session.
        if (!empty($data['reset-filter'])) {
            $this->filters = [];
        }

        // Save the new data into the session
        session()->put($sessionKey, $this->filters);
        return $this->filters;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function single($key)
    {
        if (is_array($key)) {
            throw new \Exception('Key for FilterService can\'t be an array');
        }
        if (!empty($this->filters) && isset($this->filters[$key])) {
            return $this->filters[$key];
        }
        return null;
    }
}
