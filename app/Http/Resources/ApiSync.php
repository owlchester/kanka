<?php


namespace App\Http\Resources;


use App\Services\Api\ApiService;
use Carbon\Carbon;

trait ApiSync
{
    /**
     * Create new anonymous resource collection.
     *
     * @param  mixed  $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        $additional = [
            'sync' => Carbon::now(),
        ];
        if (config('app.debug')) {
            $additional['queries'] = new ApiService();
        }

        // Make sure we have the app's url for pagination, otherwise on prod it will skip the https scheme
        $resource->setPath(config('app.url'));

        return parent::collection($resource)
            ->additional($additional);
    }
}
