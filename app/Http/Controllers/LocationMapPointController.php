<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocation;
use App\Http\Requests\StoreMapPoint;
use App\Models\Location;
use App\Models\MapPoint;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Exception\LogicException;

class LocationMapPointController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'locations.map_points';
    protected $route = 'locations.map_points';

    /**
     * @var string
     */
    protected $model = \App\Models\MapPoint::class;

    /**
     * @param Request $request
     * @param Location $location
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, Location $location)
    {
        $this->authorize('update', $location);
        return view('locations.map.edit', compact('location'));
    }

    /**
     * @param Location $location
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Location $location)
    {
        $this->authorize('update', $location);

        $ajax = request()->ajax();
        return view('locations.map_points.create', compact('location', 'ajax'));
    }

    public function show(Location $location, MapPoint $mapPoint)
    {
        $this->authorize('break', $location);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMapPoint $request, Location $location)
    {
        $this->authorize('update', $location);

        try {
            $model = new MapPoint();
            $new = $model->create($request->all());
            return redirect()->route('locations.map.admin', $location)
                ->with('success', trans('locations.map.points.success.create'));
        } catch (LogicException $exception) {
            $error =  str_replace(' ', '_', strtolower($exception->getMessage()));
            return redirect()->back()->withInput()->with('error', trans('crud.errors.' . $error));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MapPoint  $mapPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location, MapPoint $mapPoint)
    {
        $this->authorize('update', $location);
        $model = $mapPoint;
        $ajax = request()->ajax();

        return view('locations.map_points.edit', compact('location', 'model', 'ajax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @param  \App\Models\MapPoint  $mapPoint
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMapPoint $request, Location $location, MapPoint $mapPoint)
    {
        $this->authorize('update', $location);

        try {
            if ($request->has('remove')) {
                $mapPoint->delete();
                return redirect()->route('locations.map.admin', $location)
                    ->with('success', trans('locations.map.points.success.delete'));
            }
            $mapPoint->update($request->all());
            return redirect()->route('locations.map_points.index', $location)
                ->with('success', trans('locations.map.points.success.update'));
        } catch (LogicException $exception) {
            $error =  str_replace(' ', '_', strtolower($exception->getMessage()));
            return redirect()->back()->withInput()->with('error', trans('crud.errors.' . $error));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @param  \App\Models\MapPoint  $mapPoint
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, Location $location, MapPoint $mapPoint)
    {
        $this->authorize('update', $location);

        try {
            $mapPoint->update($request->only('axis_y', 'axis_x'));
            die("yop");
            return true;
        } catch (LogicException $exception) {
            //
        }
        die("nop");
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @param  \App\Models\MapPoint  $mapPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, MapPoint $mapPoint)
    {
        $this->authorize('update', $location);

        $mapPoint->delete();
        return redirect()->route($this->route . '.show', [$location, '#map'])
            ->with('success', trans($this->view . '.destroy.success', ['name' => $mapPoint->location->name]));
    }
}
