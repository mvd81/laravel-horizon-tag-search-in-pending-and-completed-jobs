<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use RuntimeException;
use Laravel\Horizon\Horizon as BaseHorizon;

class CustomHorizon extends BaseHorizon
{
    /**
     * Get the JS for the Horizon dashboard.
     *
     * @return \Illuminate\Contracts\Support\Htmlable
     */
    public static function js()
    {
        if (($js = @file_get_contents(__DIR__.'/../dist/app.js')) === false) {
            throw new RuntimeException('Unable to load the Horizon dashboard JavaScript.');
        }

        $horizon = Js::from(static::scriptVariables());

        return new HtmlString(<<<HTML
            <script type="module">
                window.Horizon = {$horizon};
                {$js}
            </script>
            HTML);
    }
}
