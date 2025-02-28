<?php

namespace App\Http\Controllers\API\Inquiries;

use App\Http\Services\InquiryService;
use Illuminate\Http\Request;

class InquiriesController
{
    public InquiryService $inquiryService;

    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
    }

    public function store(Request $request)
    {
        try {
            $validated = \Validator::make($request->all(), [
                'treatment_id' => 'required|integer',
                'language_id' => 'required|integer',
                'status' => 'required|integer',
                'gender' => 'nullable|integer',
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
                return response()->json(['status' => 'error', 'message' => __('Eksik Bilgiler Mevcuttur. Eksik Bilgiler : '. join(', ', array_keys($validated->errors()->toArray()) ) )], 200);
            }

            $store = $this->inquiryService->create($validated->validated());

            if ($store) {
                return response()->json(['status' => 'success', 'message' => __('İşlem Başarılı')], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function index(Request $request)
    {
        try {
            $inquiries = $this->inquiryService->get();

            return response()->json(['status' => 'success', 'data' => $inquiries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }


}
