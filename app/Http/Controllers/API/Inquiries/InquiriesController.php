<?php

namespace App\Http\Controllers\API\Inquiries;

use App\Enums\InquiryStatus;
use App\Http\Services\InquiryService;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiriesController
{
    public InquiryService $inquiryService;

    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
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

    public function waiting(Request $request): \Illuminate\Http\JsonResponse
    {
        $columns = ['id', 'name_surname', 'coordinator', 'registration_date', 'treatment', 'country', 'reference'];

        // Sıralama ve sayfalama parametreleri
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        //filters
        $id  = $request->input('id');
        $language = $request->input('language');
        $status = $request->input('status') ?? InquiryStatus::WAITING->value;
        $treatment = $request->input('treatment');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $country = $request->input('country');
        $search = $request->input('query');

        //main query
        $query = Inquiry::with(['coordinator', 'treatment'])->where(['status' => $status]);

        //id
        if ( !empty($id) ) {
            $query->where('id', $id);
        }

        //language
        if ( !empty($language) ) {
            $query->where('language_id', $language);
        }

        //status
        if ( !empty($status) ) {
            $query->where('status', $status);
        }

        //country
        if ( !empty($country) ) {
            $query->where('country_id', $country);
        }

        //treatment
        if ( !empty($treatment) ) {
            $query->where('treatment_id', $treatment);
        }

        //start_date and end_date
        if ( !empty($start_date) && !empty($end_date) ) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ( !empty($start_date) ) {
            $query->where('created_at', '>=', $start_date);
        } elseif ( !empty($end_date) ) {
            $query->where('created_at', '<=', $end_date);
        }

        //search
        if ( !empty($search) ) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('message', 'like', '%'.$search.'%')
                ->orWhere('extra_data1', 'like', '%'.$search.'%')
                ->orWhere('extra_data2', 'like', '%'.$search.'%')
                ->orWhere('extra_data3', 'like', '%'.$search.'%');
        }

        //coordinator ise sadece kendi atandığı hastaları görebilir
        if ( auth()->user()->hasRole('Coordinator') ) {
            $query->where('assignment_to', auth()->id());
        }

        //toplam data
        $totalFiltered = $query->count();

        //super admin ise tüm datayı görebilir
        if ( auth()->user()->hasRole('Super Admin') ) {
            $totalData = Inquiry::count();
        } else {
            $totalData = Inquiry::where(['assignment_to' => auth()->id()])->count();
        }

        //sıralama ve sayfalama
        $inquiries = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        //data
        $data = [];
        foreach ($inquiries as $inquiry) {
            $nestedData = [
                'id' => $inquiry->id,
                'name_surname' => $inquiry->name . ' ' . $inquiry->surname,
                'coordinator' => $inquiry->coordinator->name ?? '-',
                'registration_date' => $inquiry->created_at->format('d.m.Y H:i'),
                'treatment' => $inquiry->treatment->name,
                'country' => $inquiry->country->translations->first()->name ?? '-',
                'reference' => $inquiry->reference->name ?? '-',
                'action' => ''
            ];
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function approved(Request $request) : \Illuminate\Http\JsonResponse
    {
        $columns = ['actions', 'id', 'name_surname', 'treatment', 'country', 'status', 'coordinator', 'created_at', 'email', 'phone'];

        // Sıralama ve sayfalama parametreleri
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $status = $request->input('status');

        //filters
        $id  = $request->input('id');
        $language = $request->input('language');
        $treatment = $request->input('treatment');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $country = $request->input('country');
        $search = $request->input('query');
        $coordinator = $request->input('coordinator');

        //main query
        $query = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '>=', $status);

        //coordinator ise sadece kendi atandığı hastaları görebilir
        if (!empty($coordinator) ) {
            $query->where('assignment_to', $coordinator);
        } else {
            if ( auth()->user()->hasRole('Coordinator') ) {
                $query->where('assignment_to', auth()->id());
            }

            if ( auth()->user()->hasRole('Super Admin') ) {
                $query->where('assignment_to', '!=', null);
            }
        }

        //id
        if ( !empty($id) ) {
            $query->where('id', $id);
        }

        //language
        if ( !empty($language) ) {
            $query->where('language_id', $language);
        }

        //status
        if ( !empty($status) ) {
            $query->where('status', $status);
        }

        //country
        if ( !empty($country) ) {
            $query->where('country_id', $country);
        }

        //treatment
        if ( !empty($treatment) ) {
            $query->where('treatment_id', $treatment);
        }

        //start_date and end_date
        if ( !empty($start_date) && !empty($end_date) ) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ( !empty($start_date) ) {
            $query->where('created_at', '>=', $start_date);
        } elseif ( !empty($end_date) ) {
            $query->where('created_at', '<=', $end_date);
        }

        //search
        if ( !empty($search) ) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('message', 'like', '%'.$search.'%')
                ->orWhere('extra_data1', 'like', '%'.$search.'%')
                ->orWhere('extra_data2', 'like', '%'.$search.'%')
                ->orWhere('extra_data3', 'like', '%'.$search.'%');
        }

        //toplam data
        $totalFiltered = $query->count();

        if ( auth()->user()->hasRole('Super Admin') ) {
            $totalData = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '>=', $status)->count();
        } else {
            $totalData = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '>=', $status)->where(['assignment_to' => $coordinator])->count();
        }

        //sıralama ve sayfalama
        $inquiries = $query->offset($start)
            ->limit($limit)
            ->when($order == 'treatment', function ($query) use ($dir) {
                return $query->orderBy('treatment_id', $dir);
            })
            ->when($order != 'treatment', function ($query) use ($order, $dir) {
                return $query->orderBy($order, $dir);
            })
            ->get();

        //data
        $data = [];
        foreach ($inquiries as $inquiry) {
            $nestedData = [
                'id' => $inquiry->id,
                'name_surname' => $inquiry->name . ' ' . $inquiry->surname,
                'coordinator' => $inquiry->coordinator->name ?? '-',
                'registration_date' => $inquiry->created_at->format('d.m.Y H:i'),
                'treatment' => $inquiry->treatment->name,
                'country' => $inquiry->country->translations->first()->name ?? '-',
                'status' => __(\App\Enums\InquiryStatus::from($inquiry->status)->getLabel() ),
                'status_id' => $inquiry->status,
                'code' => $inquiry->answers->code ?? '',
                'medical_form_link' => route('medical-forms.show', $inquiry->answers->code ?? '') ?? '',
                'action' => '',
                'email' => $inquiry->email,
                'phone' => $inquiry->phone
            ];
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function show(Request $request, $id)
    {
        try {
            $inquiry = $this->inquiryService->get(['id' => $id]);

            return response()->json(['status' => 'success', 'data' => $inquiry], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
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
}
