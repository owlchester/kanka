<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::group([
    'middleware' => ['auth:api', 'throttle:rate_limit,1'],
    'namespace'  => 'Api\v1',
    'prefix'     => 'v1',
], function() {
    require base_path('routes/api.v1.php');
});*/

Route::group([
    'middleware' => ['auth:api', 'throttle:rate_limit,1'],
    'namespace' => 'Api\v1',
    'prefix' => '1.0',
], function () {
    require base_path('routes/api.v1.php');
});

Route::group([
    'namespace' => 'Api\Public',
    'prefix' => 'public',
], function () {
    require base_path('routes/api-public.php');
});
