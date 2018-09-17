<?php

use Illuminate\Http\Request;

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

Route::group([
    'middleware' => ['auth:api', 'throttle:60,1'],
    'namespace'  => 'Api\v1',
    'prefix'     => 'v1',
], function() {
    require base_path('routes/api.v1.php');
});
