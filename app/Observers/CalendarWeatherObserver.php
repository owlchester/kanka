<?php
/**
 * Description of the Calendar Weather Observer
 *
 * @author Ilestis
 * 27/01/2020
 */

namespace App\Observers;

use App\Models\CalendarWeather;

class CalendarWeatherObserver
{
    use PurifiableTrait;

    /**
     * @param CalendarWeather $model
     */
    public function saving(CalendarWeather $model)
    {
        $model->weather = $this->purify($model->weather);
        $model->temperature = $this->purify($model->temperature);
        $model->precipitation = $this->purify($model->precipitation);
        $model->wind = $this->purify($model->wind);
        $model->effect = $this->purify($model->effect);
    }
}
