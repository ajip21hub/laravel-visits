<?php

namespace awssat\Visits;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class VisitsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/visits.php' => config_path('visits.php'),
        ], 'config');

        Carbon::macro('endOfxHours', function ($xhours) {
            if ($xhours > 12) {
                throw new \Exception('12 is the maximum period in xHours feature');
            }
            $h = $this->hour;

            return $this->setTime(
                ($h % $xhours == 0 ? 'min' : 'max')($h - ($h % $xhours), $h - ($h % $xhours) + $xhours),
                59,
                59
            );
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/visits.php',
            'visits'
        );
    }
}
