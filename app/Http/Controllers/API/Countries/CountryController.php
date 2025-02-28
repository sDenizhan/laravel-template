<?php

namespace App\Http\Controllers\API\Countries;

use App\Http\Controllers\Controller;
use App\Http\Services\CountryService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Client\Request;

class CountryController extends Controller
{
    public CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function all()
    {
        try {
            $countries = $this->countryService->get();
            return response()->json(['status' => 'success', 'data' => $countries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function find(?int $countryId)
    {
        try {
            $country = $this->countryService->get(['id' => $countryId]);
            return response()->json(['status' => 'success', 'data' => $country], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function create(Request $request)
    {
        try {

            $validated = \Validator::make($request->all(), [
                'code' => 'required',
                'code_alpha3' => 'required',
                'phone_code' => 'required',
                'name' => 'required'
            ]);

            $validated = $validated->validate();

            $country = $this->countryService->create($validated);
            return response()->json(['status' => 'success', 'data' => $country], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, ?int $countryId)
    {
        try {
            $validated = \Validator::make($request->all(), [
                'code' => 'required',
                'code_alpha3' => 'required',
                'phone_code' => 'required',
                'name' => 'required'
            ]);

            $validated = $validated->validate();

            $country = $this->countryService->update($countryId, $validated);
            return response()->json(['status' => 'success', 'data' => $country], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function delete(?int $countryId)
    {
        try {
            $country = $this->countryService->delete($countryId);
            return response()->json(['status' => 'success', 'data' => $country], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
