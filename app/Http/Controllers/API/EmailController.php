<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Mail\SendngEmailForMedicalForm;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function medicalFormSendingWithEmail(Request $request)
    {
        $inquiry = Inquiry::find($request->id);

        $subject = 'Medical Form';
        $message = $request->message;

        Mail::to($inquiry->email)->send(new SendngEmailForMedicalForm($inquiry, $subject, $message));

        return response()->json(['message' => 'Email sent successfully']);
    }
}
