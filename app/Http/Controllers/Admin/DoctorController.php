<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('doctor.index');
    }

    public function anaesthetist()
    {
        return view('doctor.anaesthetist');
    }

    public function sendingAnaesthetist(Request $request)
    {
        $validations = \Validator::make($request->all(), [
            'doctor_id' => 'required',
            'inquiry_id' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request!'], 200);
        }

        $validated = (object) $validations->validated();
        $inquiry = \App\Models\Inquiry::find($validated->inquiry_id);

        if (!$inquiry) {
            return response()->json(['status' => 'error', 'message' => 'Inquiry not found!'], 200);
        }

        $doctors = User::whereIn('id', $validated->doctor_id)->get();

        if ($doctors->count() == 0) {
            return response()->json(['status' => 'error', 'message' => 'Doctor not found!'], 200);
        }

        event(new \App\Events\EventAfterSendingToAnaesthetistDoctors($doctors, $inquiry));

        return response()->json(['status' => 'success', 'message' => 'Anaesthetist has been sent!'], 200);
    }

}
