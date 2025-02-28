<?php

namespace App\Http\Controllers\API\Hospitals;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Services\HospitalService;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public HospitalService $hospitalService;

    public function __construct(HospitalService $hospitalService)
    {
        $this->hospitalService = $hospitalService;
    }

    public function find(?int $id = null)
    {
        try {
            $hospital = $this->hospitalService->get(['id' => $id]);

            return response()->json(['status' => 'success', 'data' => $hospital], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function store(StoreHospitalRequest $request)
    {
        try {

            $doctors = $request->input('doctors');
            $anaesthetists = $request->input('anaesthetists');

            $validated = \Arr::except($request->validated(), ['doctors', 'anaesthetists']);

            $hospital = $this->hospitalService->create($validated);

            if ( $hospital) {
                if ( isset($doctors) ) {
                    $hospital = $this->hospitalService->attachUsers($hospital->id, $doctors);
                }

                if ( isset($anaesthetists) ) {
                    $hospital = $this->hospitalService->attachUsers($hospital->id, $anaesthetists);
                }
            }

            return response()->json(['status' => 'success', 'message' => __('Hastane Oluşturuldu!'), 'data' => $hospital], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function update(?int $id = null, ?array $data = [])
    {
        try {
            $hospital = $this->hospitalService->update($id, $data);

            return response()->json(['status' => 'success', 'data' => $hospital], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function delete(?int $id = null)
    {
        try {
            $hospital = $this->hospitalService->delete($id);

            return response()->json(['status' => 'success', 'message' => __('Hastane Silindi!')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

    }
}
