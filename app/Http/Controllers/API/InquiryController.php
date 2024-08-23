<?php

namespace App\Http\Controllers\API;

use App\Enums\InquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreInquiryRequest;
use App\Models\Inquiry;
use App\Models\Status;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function waiting()
    {
        $inquiries = Inquiry::where('status', InquiryStatus::WAITING)->get();
        $data = [];

        foreach ($inquiries as $inquiry) {
            $data[] = [
                'id' => $inquiry->id,
                'name' => $inquiry->name,
                'surname' => $inquiry->surname,
                'email' => $inquiry->email,
                'phone' => $inquiry->phone,
                'message' => $inquiry->message,
                'country' => $inquiry->country,
                'ip_address' => $inquiry->ip_address,
                'created_at' => $inquiry->created_at->format('d F Y H:i:s'),
                'treatment' => $inquiry->treatment->name,
                'status' => InquiryStatus::from($inquiry->status)->name,
            ];
        }

        return response()->json(['status' => 'success', 'message' => '', 'data' => $data]);
    }

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
