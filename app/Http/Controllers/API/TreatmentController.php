<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Treatments;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => 'success', 'message' => '', 'data' => Treatments::all()->toArray()]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $validated = $validator->validated();

        $treatment = new Treatments();
        $treatment->name = $validated['name'];
        $treatment->status = 1;

        if ($treatment->save()) {
            return response()->json(['status' => 'success', 'message' => 'Treatment added successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'An error occurred while adding the treatment.']);
    }
}
