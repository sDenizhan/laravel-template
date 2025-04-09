<?php

namespace App\Http\Controllers;

use App\Enums\InquiryStatus;
use App\Events\InquiryCreated;
use App\Models\CountryTranslation;
use App\Models\Inquiry;
use App\Models\Language;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function web(Request $request)
    {
        $validated = \Validator::make($request->all(), [
            'treatment_id' => 'required|integer',
            'country_id' => 'required|string',
            'gender' => 'required|integer',
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
            'ip_address' => 'nullable',
            'language' => 'required|string',
            'assignment_by' => 'nullable',
            'assignment_to' => 'nullable',
            'assignment_at' => 'nullable',
            'extra_data' => 'nullable|string',
        ]);

        if ($validated->fails() ){
            return response()
                ->json([
                    'status' => 'error',
                    'message' => __('Eksik Bilgiler Mevcuttur. Lütfen Tekrar Deneyiniz.! Eksik Bilgiler : '. join(', ', array_keys($validated->errors()->toArray()) ) )], 200);
        }

        $input = (object) $validated->validated();

        $languageId = Language::where('code', $input->language)->first()->id ?? Language::where(['code' => 'en'])->first()->id;

        if ( $languageId == null ) {
            return response()->json(['status' => 'error', 'message' => 'Dil Bilgisi Bulunamadı!'], 200);
        }

        $countryId = CountryTranslation::where(['name' => $input->country_id, 'locale' => 'en'])->first()->country_id ?? CountryTranslation::where(['name' => 'Türkiye', 'locale' => 'tr'])->first()->country_id;

        if ( $countryId == null ) {
            return response()->json(['status' => 'error', 'message' => 'Ülke Bilgisi Bulunamadı!'], 200);
        }

        $ipAddress = $input->ip_address ?? request()->ip();

        if ( $ipAddress == null ) {
            return response()->json(['status' => 'error', 'message' => 'IP Adresi Bulunamadı!'], 200);
        }

        $store = Inquiry::create([
            'treatment_id' => $languageId,
            'country_id' => $countryId,
            'language_id' => $languageId,
            'name' => $input->name,
            'surname' => $input->surname,
            'email' => $input->email,
            'phone' => $input->phone,
            'message' => $input->message,
            'ip_address' => $ipAddress,
            'gender' => $input->gender,
            'extra_data1' => $input->extra_data,
            'status' => InquiryStatus::WAITING->value,
        ]);

        if ( $store ) {
            return response()->json(['status' => 'success', 'message' => 'Başvurunuz Kayıt Edildi..!'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Başvurunuz Kayıt Edilemedi!' ], 200);
        }
    }
}
