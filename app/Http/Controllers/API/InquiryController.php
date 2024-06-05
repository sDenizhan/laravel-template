<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusWaitingInquiry;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreInquiryRequest;
use App\Models\Inquiry;
use App\Models\Status;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = \Validator::make($request->all(), [
            'treatment_id' => 'required|integer',
            'gender' => 'required|integer',
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
            'country' => 'required|string',
            'ip_address' => 'required|string',
            'assignment_by' => 'nullable',
            'assignment_to' => 'nullable',
            'assignment_at' => 'nullable',
        ]);

        if ($validated->fails() ){
            return response()->json(['status' => 'error', 'message' => 'Başvurunuz Kayıt Edilemedi!' ], 200);
        }

        $store = Inquiry::create($validated->validated());

        if ( $store ) {
            return response()->json(['status' => 'success', 'message' => 'Başvurunuz Kayıt Edildi..!'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Başvurunuz Kayıt Edilemedi!' ], 200);
        }
    }
}
