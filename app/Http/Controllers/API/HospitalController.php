<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        $data = [];
        $hospitals = Hospital::all()->toArray();

        foreach ($hospitals as $hospital) {
            $data[] = [
                'id' => $hospital['id'],
                'name' => $hospital['name'],
                'status' => $hospital['status'] == 1 ? 'active' : 'inactive',
            ];
        }

        return response()->json(['status' => 'success', 'message' => '', 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $validated = $validator->validated();

        $hospital = new Hospital();
        $hospital->name = $validated['name'];
        $hospital->status = 1;

        if ($hospital->save()) {
            return response()->json(['status' => 'success', 'message' => 'Hospital added successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'An error occurred while adding the hospital.']);

    }
}
