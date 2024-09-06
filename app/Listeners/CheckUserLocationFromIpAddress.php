<?php

namespace App\Listeners;

use App\Jobs\CheckIpAddressFromGeoApi;
use App\Models\LoginLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class CheckUserLocationFromIpAddress
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $agent = new Agent();
        $agent->setUserAgent(\Request::userAgent());

        //create login logs
        $log = LoginLog::create([
            'user_id' => Auth::id(),
            'ip_address' => \Request::ip(),
            'user_agent' => \Request::userAgent(),
            'location' => [
                'timezone' => \Request::input('timezone'),
            ],
            'device' => $agent->device(),
            'platform' => $agent->platform(),
        ]);

        //dispatch job
        CheckIpAddressFromGeoApi::dispatch(\Request::ip(), $log->id)->delay(now()->addMinutes(1));
    }
}
