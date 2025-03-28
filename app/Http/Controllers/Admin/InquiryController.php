<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InquiryStatus;
use App\Events\InquiryStoredEvent;
use App\Events\MedicalFormSentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryStoreRequest;
use App\Http\Requests\StoreMedicalFormNotes;
use App\Http\Requests\StoreMedicalFormRequest;
use App\Models\Calendar;
use App\Models\DoctorHasInquiry;
use App\Models\Inquiry;
use App\Models\Language;
use App\Models\MedicalForm;
use App\Models\MedicalFormNotes;
use App\Models\MedicalFormPatientAnswers;
use App\Models\MessageTemplate;
use App\Models\Treatments;
use App\Models\User;
use App\Models\CountryTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use LaravelLang\Publisher\Concerns\Has;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-inquiry|edit-inquiry|delete-inquiry', ['only' => ['index','show']]);
        $this->middleware('permission:create-inquiry', ['only' => ['create','store']]);
        $this->middleware('permission:edit-inquiry', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-inquiry', ['only' => ['destroy']]);
    }

    public function waiting()
    {
        return view('inquiry.waiting');
    }

    public function filter(Request $request) : \Illuminate\Http\JsonResponse
    {
        $columns = ['id', 'name_surname', 'coordinator', 'registration_date', 'treatment', 'country'];

        // Sıralama ve sayfalama parametreleri
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $status = $request->input('status');

        // Filtreleme
        $search = $request->input('search.value');

        //main query
        $query = Inquiry::with(['coordinator', 'treatment'])->where(['status' => $status]);

        //coordinator ise sadece kendi atandığı hastaları görebilir
        if ( auth()->user()->hasRole('Coordinator') ) {
            $query->where('assignment_to', auth()->id());
        }

        //search
        if ( !empty($search) ) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%')
                ->orWhereHas('treatment', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
        }

        //toplam data
        $totalFiltered = $query->count();

        if ( auth()->user()->hasRole('Super Admin') ) {
            $totalData = Inquiry::where('status', '=', $status)->count();
        } else {
            $totalData = Inquiry::where('status', '=', $status)->where(['assignment_to' => auth()->id()])->count();
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

    public function approved(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('inquiry.approved');
    }

    public function approved_filter(Request $request) : \Illuminate\Http\JsonResponse
    {
        $columns = ['actions', 'id', 'name_surname', 'treatment', 'country', 'status', 'coordinator', 'created_at', 'email', 'phone'];

        // Sıralama ve sayfalama parametreleri
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $status = $request->input('status');

        // Filtreleme
        $search = $request->input('search.value');

        //main query
        $query = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '>=', $status);

        //coordinator ise sadece kendi atandığı hastaları görebilir
        if ( auth()->user()->hasRole('Coordinator') ) {
            $query->where('assignment_to', auth()->id());
        }

        //search
        if ( !empty($search) ) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%')
                ->orWhereHas('treatment', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
        }

        //toplam data
        $totalFiltered = $query->count();

        if ( auth()->user()->hasRole('Super Admin') ) {
            $totalData = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '>=', $status)->count();
        } else {
            $totalData = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '>=', $status)->where(['assignment_to' => auth()->id()])->count();
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

    public function anaesthetist()
    {
        if ( !auth()->user()->hasPermissionTo('view-anaesthetist-inquiries') && !auth()->user()->hasRole('Super Admin') ) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to view this page!');
        }

        return view('inquiry.anaesthetist');
    }

    public function anaesthetist_filter(Request $request) : \Illuminate\Http\JsonResponse
    {
        $columns = ['id', 'name_surname', 'treatment', 'country', 'status', 'coordinator', 'registration_date'];

        // Sıralama ve sayfalama parametreleri
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $status = InquiryStatus::ANESTHESIA_SENT->value;

        // Filtreleme
        $search = $request->input('search.value');

        //main query
        $query = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '=', $status);

        //search
        if ( !empty($search) ) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%')
                ->orWhereHas('treatment', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
        }

        //toplam data
        $totalFiltered = $query->count();
        $totalData = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '=', $status)->count();

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
                'name_surname' => maskWord($inquiry->name) . ' ' . maskWord($inquiry->surname),
                'coordinator' => $inquiry->coordinator->name ?? '-',
                'registration_date' => $inquiry->created_at->format('d.m.Y H:i'),
                'treatment' => $inquiry->treatment->name,
                'country' => $inquiry->country,
                'status' => __(\App\Enums\InquiryStatus::from($inquiry->status)->getLabel() ),
                'status_id' => $inquiry->status,
                'code' => $inquiry->answers->code ?? '',
                'medical_form_link' => route('medical-forms.show', $inquiry->answers->code) ?? '',
                'action' => ''
            ];
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => auth()->user()->hasRole('Super Admin') ? $data : collect($data)->filter(function ($item) {

                $inquiry = DoctorHasInquiry::where(['doctor_id' => auth()->id()])->first() ?? null;

                if (!$inquiry) {
                    return false;
                }

                return $inquiry->inquiry_id == $item['id'];

            })->values()
        ];

        return response()->json($json_data);
    }

    //doctors
    public function doctors()
    {
        if ( !auth()->user()->hasPermissionTo('doctor-can-view-inquiry') && !auth()->user()->hasRole('Super Admin') ) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to view this page!');
        }

        return view('inquiry.doctors');
    }

    public function doctors_filter(Request $request) : \Illuminate\Http\JsonResponse
    {
        $columns = ['id', 'name_surname', 'treatment', 'country', 'status', 'coordinator', 'registration_date'];

        // Sıralama ve sayfalama parametreleri
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $status = InquiryStatus::DOCTOR_SENT->value;

        // Filtreleme
        $search = $request->input('search.value');

        //main query
        $query = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '=', $status);

        //search
        if ( !empty($search) ) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%')
                ->orWhereHas('treatment', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
        }

        //toplam data
        $totalFiltered = $query->count();
        $totalData = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '=', $status)->count();

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
                'name_surname' => maskWord($inquiry->name) . ' ' . maskWord($inquiry->surname),
                'coordinator' => $inquiry->coordinator->name ?? '-',
                'registration_date' => $inquiry->created_at->format('d.m.Y H:i'),
                'treatment' => $inquiry->treatment->name,
                'country' => $inquiry->country,
                'status' => __(\App\Enums\InquiryStatus::from($inquiry->status)->getLabel() ),
                'status_id' => $inquiry->status,
                'code' => $inquiry->answers->code ?? '',
                'medical_form_link' => route('medical-forms.show', $inquiry->answers->code) ?? '',
                'action' => ''
            ];
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => auth()->user()->hasRole('Super Admin') ? $data : collect($data)->filter(function ($item) {

                $inquiry = DoctorHasInquiry::where(['doctor_id' => auth()->id()])->first() ?? null;

                if (!$inquiry) {
                    return false;
                }

                return $inquiry->inquiry_id == $item['id'];

            })->values()
        ];

        return response()->json($json_data);
    }


    //completed
    public function completed()
    {
        if ( !auth()->user()->hasPermissionTo('view-completed-inquiries') && !auth()->user()->hasRole('Super Admin') ) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to view this page!');
        }

        return view('inquiry.completed');
    }

    public function completed_filters(Request $request) : \Illuminate\Http\JsonResponse
    {
        $columns = ['id', 'name_surname', 'treatment', 'country', 'status', 'coordinator', 'registration_date'];

        // Sıralama ve sayfalama parametreleri
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $status = InquiryStatus::OPERATION_DONE->value;

        // Filtreleme
        $search = $request->input('search.value');

        //main query
        $query = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '=', $status);

        //search
        if ( !empty($search) ) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('surname', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%')
                ->orWhereHas('treatment', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
        }

        //toplam data
        $totalFiltered = $query->count();
        $totalData = Inquiry::with(['coordinator', 'treatment', 'answers'])->where('status', '=', $status)->count();

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
                'name_surname' => maskWord($inquiry->name) . ' ' . maskWord($inquiry->surname),
                'coordinator' => $inquiry->coordinator->name ?? '-',
                'registration_date' => $inquiry->created_at->format('d.m.Y H:i'),
                'treatment' => $inquiry->treatment->name,
                'country' => $inquiry->country,
                'status' => __(\App\Enums\InquiryStatus::from($inquiry->status)->getLabel() ),
                'status_id' => $inquiry->status,
                'code' => $inquiry->answers->code ?? '',
                'medical_form_link' => route('medical-forms.show', $inquiry->answers->code) ?? '',
                'action' => ''
            ];
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => auth()->user()->hasRole('Super Admin') ? $data : collect($data)->filter(function ($item) {

                $inquiry = Inquiry::where(['assigment_to' => auth()->id()])->first() ?? null;

                if (!$inquiry) {
                    return false;
                }

                return $inquiry->inquiry_id == $item['id'];

            })->values()
        ];

        return response()->json($json_data);
    }

    public function makeTreatmentSchedule(Request $request, $inquiry)
    {
        $inquiry = Inquiry::find($inquiry);
        return view('inquiry.treatment-wizard', compact('inquiry'));
    }

    public function saveTreatmentSchedule(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'inquiry_id' => 'required|exists:inquiries,id',
        ]);

        $validated = (object) $validator->validated();

        $inquiry = Inquiry::find($validated->inquiry_id);

        $inquiry->update([
            'treatment_schedule' => json_encode($request->all()),
            'status' => InquiryStatus::PLANNED->value
        ]);


        $calendar = Calendar::create([
            'user_id' => $inquiry->assignment_to,
            'title' => $inquiry->name . ' ' . $inquiry->surname,
            'start' => $request->operation_date,
            'end' => $request->operation_date,
            'data' => json_encode([
                'doctor' => $request->doctor_id,
                'hospital' => $request->hospital_id,
                'notes' => $request->notes,
                'operation_date' => $request->operation_date,
            ])
        ]);

        return response()->json(['status' => 'success', 'message' => 'Treatment schedule saved successfully']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = Inquiry::all();
        return view('inquiry.waiting', compact('inquiries'));
    }

    public function statusUpdate(Request $request)
    {

        $validated = \Validator::make($request->all(), [
            'id' => 'required|exists:inquiries,id',
            'status' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first() ]);
        }

        $inquiry = Inquiry::find($request->id);
        $inquiry->update([
            'status' => $request->status
        ]);

        return response()->json(['status' => 'success', 'message' => 'Inquiry status updated successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InquiryStoreRequest $request)
    {
        //
        $validated = $request->validated();
        $inquiry = Inquiry::find($validated['id']);

        $inquiry->update([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country_id' => $validated['country_id'],
            'ip_address' => request()->ip(),
            'treatment_id' => $validated['treatment_id'],
            'language_id' => $validated['language_id'],
            'assignment_to' => $validated['coordinator_id'],
            'assignment_by' => auth()->id(),
            'assignment_at' => date('Y-m-d H:i:s'),
            'message' => $validated['message'],
            'status' => InquiryStatus::APPROVED->value
        ]);

        event(new InquiryStoredEvent($inquiry));

        return response()->json(['status' => 'success', 'message' => 'Inquiry updated successfully']);
    }

    public function getInquiryMessageTemplate(Request $request)
    {
        $validated = \Validator::make($request->all(), [
            'id' => 'required|exists:inquiries,id',
            'function' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()]);
        }

        $input = (object) $validated->validated();
        $inquiry = Inquiry::find($input->id);

        $messageTemplate = MessageTemplate::where([
            'treatment_id' => $inquiry->treatment_id,
            'language_id' => $inquiry->language_id,
            'type' => $input->function,
            'action' => 'medical_form'
        ])->first();

        if (!$messageTemplate) {
            return response()->json(['status' => 'error', 'message' => 'Message template not found']);
        }

        $user = User::where(['email' => $inquiry->email])->first();

        if ( !$user ) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        $medicalForm = MedicalForm::where([
            'treatment_id' => $inquiry->treatment_id,
            'language_id' => $inquiry->language_id
        ])->first();

        if (!$medicalForm) {
            return response()->json(['status' => 'error', 'message' => 'Medical form not found']);
        }

        $medicalformPatientAnswers = MedicalFormPatientAnswers::where([
            'inquiry_id' => $inquiry->id,
            'user_id' => $inquiry->user_id,
        ])->first();

        if ( !$medicalformPatientAnswers ) {
            $hashKey = Arr::join([$inquiry->id, $inquiry->email, $inquiry->phone], '-');
            $formHash = Str::of(Hash::make($hashKey))->upper()->limit(16, '')->replace('/', 'A')->replace('$', 'B');

            $medicalformPatientAnswers = MedicalFormPatientAnswers::create([
                'inquiry_id' => $inquiry->id,
                'medical_form_id' => $medicalForm->id,
                'user_id' => $inquiry->user_id,
                'code' => $formHash,
                'answers' => [],
                'last_answers_at' => Carbon::create(Carbon::now())->addDays(365)
            ]);

        } else {
            $formHash = $medicalformPatientAnswers->code;
        }

        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{patient_name}}', $inquiry->name);
        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{patient_surname}}', $inquiry->surname);
        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{your_medical_form_link}}', route('medical-forms.show', $formHash));

        $html = view('components.backend.inquiries.modal.medical-form-message-for-email',
                            compact('inquiry', 'messageTemplate', 'user', 'formHash', 'medicalForm'))
                ->render();

        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function send_with_whatsapp(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = \Validator::make($request->all(), [
            'id' => 'required|exists:inquiries,id',
            'message' => 'required',
            'userId' => 'required|exists:users,id',
            'formHash' => 'required',
            'medicalFormId' => 'required|exists:medical_forms,id'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Inquiry not found']);
        }

        $input = (object) $validated->validated();

        $inquiry = Inquiry::find($input->id);

        $medicalformPatientAnswers = MedicalFormPatientAnswers::where(['id' => $input->medicalFormId, 'user_id' => $inquiry->userId])->first();

        $user = User::find($input->userId);

        event(new MedicalFormSentEvent($inquiry, $user, $medicalformPatientAnswers));

        return response()->json(['status' => 'success', 'message' => 'Message sent it with WhatsApp..!', 'url' => 'https://wa.me/'. $inquiry->phone .'?text='.urlencode(html_to_markdown($input->message))]);
    }

    public function send_with_telegram(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = \Validator::make($request->all(), [
            'id' => 'required|exists:inquiries,id',
            'message' => 'required',
            'userId' => 'required|exists:users,id',
            'formHash' => 'required',
            'medicalFormId' => 'required|exists:medical_forms,id'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Inquiry not found']);
        }

        $input = (object) $validated->validated();

        $inquiry = Inquiry::find($input->id);

        $medicalformPatientAnswers = MedicalFormPatientAnswers::where(['id' => $input->medicalFormId, 'user_id' => $inquiry->userId])->first();

        $user = User::find($input->userId);

        event(new MedicalFormSentEvent($inquiry, $user, $medicalformPatientAnswers));

        return response()->json(['status' => 'success', 'message' => 'Message sent it with WhatsApp..!', 'url' => 'https://t.me/'. $inquiry->phone .'?text='.urlencode(html_to_markdown($input->message))]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = Inquiry::find($id);
        $coordinators = User::whereHas('roles', function ($query) {
            $query->where('name', 'coordinator');
        })->get();

        $treatments = Treatments::all();
        $languages = Language::all();
        $countries = CountryTranslation::where('locale', session()->get('locale') ?? 'tr')->orderBy('name', 'asc')->get();

        $html = view('components.backend.inquiries.modal.edit-form', compact('inquiry', 'coordinators', 'treatments', 'languages', 'countries'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function create()
    {

        $coordinators = User::when(!auth()->user()->hasRole('Super Admin'), function ($query){
                                return $query->where('id', auth()->id());
                            })->when(auth()->user()->hasRole('Super Admin'), function ($query){
                                return $query->whereHas('roles', function ($query) {
                                    $query->where('name', 'coordinator');
                                });
                            })->get();

        $treatments = Treatments::all();
        $languages = Language::all();

        $html = view('components.backend.inquiries.modal.new-inquiry-form', compact( 'coordinators', 'treatments', 'languages'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function findCustomer(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $validated = (object) $validator->validated();

        $users = User::where('name', 'like', '%'.$validated->name.'%')->orWhere('email', 'like', '%'. $validated->name .'%')->get();

        if ($users->count() == 0) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        return response()->json(['status' => 'success', 'users' => $users]);
    }

    public function findInquiry(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $validated = (object) $validator->validated();

        $inquiry = Inquiry::where(['user_id' => $validated->id])->first();

        if (!$inquiry) {
            return response()->json(['status' => 'error', 'message' => 'Inquiry not found']);
        }

        return response()->json(['status' => 'success', 'inquiry' => $inquiry]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function saveNotes(StoreMedicalFormNotes $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $medicalForm = MedicalFormPatientAnswers::find($validated['answer_id']);

        if (!$medicalForm) {
            return response()->json(['status' => 'error', 'message' => 'Medical form not found']);
        }

        $medicalFormNote = MedicalFormNotes::create([
            'inquiry_id' => $validated['inquiry_id'],
            'medical_form_id' => $validated['answer_id'],
            'user_id' => $validated['user_id'],
            'note' => $validated['notes']
        ]);

        return response()->json(['status' => 'success', 'message' => 'Notes updated successfully']);
    }

    public function getNotes(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = \Validator::make($request->all(), [
            'inquiry_id' => 'required|exists:inquiries,id',
            'medical_form_id' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()]);
        }

        $validated = (object) $validated->validated();

        $notes = MedicalFormNotes::with('user')->where([
            'inquiry_id' => $validated->inquiry_id,
            'medical_form_id' => $validated->medical_form_id
        ])->get();

        if ($notes->count() == 0) {
            return response()->json(['status' => 'error', 'message' => 'Notes not found']);
        }

        $view = view('components.backend.medical-forms.list-notes', compact('notes'))->render();

        return response()->json(['status' => 'success', 'html' => $view]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //view medical form
    public function viewMedicalForm(Request $request, ?int $formId = null)
    {
        if ( !$formId ) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid request!');
        }

        $medicalForm = MedicalFormPatientAnswers::where(['inquiry_id' => $formId])->first();

        if (!$medicalForm) {
            return redirect()->route('admin.dashboard')->with('error', 'Medical form not found!');
        }

        //doctor check
        if ( !auth()->user()->hasRole('Super Admin') ) {
            $doctorHasInquiry = DoctorHasInquiry::where(['doctor_id' => auth()->id(), 'inquiry_id' => $formId])->first();
            if (!$doctorHasInquiry) {
                return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to view this form!');
            }
        }

        //coordinator check
        if ( auth()->user()->hasRole('Coordinator') ) {
            $inquiry = Inquiry::find($formId);
            if ($inquiry->assignment_to != auth()->id()) {
                return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to view this form!');
            }
        }

        return view('inquiry.view-medical-form', compact('medicalForm'));
    }
}
