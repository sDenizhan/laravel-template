<?php

namespace App\Listeners;

use App\Enums\Gender;
use App\Events\InquiryCreated;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InquiryCreatedListener
{
    /**
     * Handle the event.
     */
    public function handle(InquiryCreated $event): void
    {
        //created user
        $this->createPatientUser($event);

        //create log
        $this->createLog($event);

        //check gender
        $this->checkGender($event);
    }

    private function createPatientUser(InquiryCreated $event): void
    {
        $name = $event->inquiry->name;
        $surname = $event->inquiry->surname;
        $email = $event->inquiry->email;
        $password = bcrypt($event->inquiry->phone);

        $user = User::firstOrCreate(
            [
                'email' => $email,
            ],
            [
                'name' => $name.' '. $surname,
                'email' => $email,
                'password' => $password,
                'reference_code' => Str::of(Str::random(10))->upper(),
            ]);
        $user->assignRole('Patient');

        Inquiry::where('id', $event->inquiry->id)->update(['user_id' => $user->id]);
    }

    public function createLog(InquiryCreated $event): void
    {
        $user = User::find(auth()->user()->id);

        if (!$user){
            Log::log('error', 'User not found');
        }

    }

    public function checkGender(InquiryCreated $event): void
    {
        $user = User::find($event->inquiry->user_id);

        if (!$user){
            Log::log('error', 'User not found');
        }

        $apiKey = env('GENDERAPI_KEY');
        $name = $event->inquiry->name;
        $client = \Http::get('https://gender-api.com/get?name='.$name.'&key='. $apiKey);

        if (!$client->failed()) {
            $response = $client->json();
            $gender = $response['gender'] == 'female' ? Gender::Female->value : Gender::Male->value;
            $event->inquiry->update(['gender' => $gender]);
        }
    }
}
