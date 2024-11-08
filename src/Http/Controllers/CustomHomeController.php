<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers ;

use Illuminate\Support\Facades\App;

class CustomHomeController {

    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('custom-horizon::layout', [
            'isDownForMaintenance' => App::isDownForMaintenance(),
        ]);
    }
}