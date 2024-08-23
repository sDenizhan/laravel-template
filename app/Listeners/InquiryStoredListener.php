<?php

namespace App\Listeners;

use App\Events\InquiryStoredEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $username = $inquiry->inquiry->name;
        $email = $inquiry->inquiry->email;
        $password = bcrypt($inquiry->inquiry->phone);

        $user = User::create([
            'name' => $username,
            'email' => $email,
            'password' => $password,
        ]);
        $user->assignRole('Patient');
    }
}
