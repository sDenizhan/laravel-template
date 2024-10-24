<?php

namespace App\Listeners;

use App\Events\InquiryStoredEvent;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class InquiryStoredListener
{

    /**
     * Handle the event.
     */
    public function handle(InquiryStoredEvent $inquiry): void
    {
        $this->createPatientUser($inquiry);
    }

    private function createPatientUser(InquiryStoredEvent $inquiry): void
    {
        $name = $inquiry->inquiry->name;
        $surname = $inquiry->inquiry->surname;
        $email = $inquiry->inquiry->email;
        $password = bcrypt($inquiry->inquiry->phone);

        $user = User::create([
            'name' => $name.' '. $surname,
            'email' => $email,
            'password' => $password,
            'reference_code' => Str::of(Str::random(10))->upper(),
        ]);
        $user->assignRole('Patient');

        Inquiry::where('id', $inquiry->inquiry->id)->update(['user_id' => $user->id]);
    }
}
