<?php

namespace App\Jobs;

use App\Models\LoginLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CheckIpAddressFromGeoApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ipAddress;
    public $logId;
    /**
     * Create a new job instance.
     */
    public function __construct(?string $ipAddress, ?int $logId)
    {
        $this->ipAddress = $ipAddress;
        $this->logId = $logId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check the IP address from the Geo API
        $request = Http::get('https://api.geoapify.com/v1/ipinfo', [
            'apiKey' => config('services.geoapify.apiKey'),
            'ip' => $this->ipAddress,
        ]);

        $response = $request->json();

        if ( array_key_exists('statusCode', $response) || $response['isPrivate'] ) {
            return;
        }

        // Update the login log with the location information
        $log = LoginLog::find($this->logId);
        $location = [
            'country' => $response['country']['names']['en'],
            'region' => $response['continent']['names']['en'],
            'city' => $response['city']['names']['en'],
            'coordinates' => join(',', [$response['location']['latitude'], $response['location']['longitude']]),
        ];
        $location = array_merge($log->location, $location);
        $log->update(['location' => $location]);
    }
}
