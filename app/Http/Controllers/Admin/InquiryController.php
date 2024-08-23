<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InquiryStatus;
use App\Events\InquiryStoredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryStoreRequest;
use App\Models\Inquiry;
use App\Models\Language;
use App\Models\MedicalForm;
use App\Models\MedicalFormPatientAnswers;
use App\Models\MessageTemplate;
use App\Models\Treatments;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use LaravelLang\Publisher\Concerns\Has;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('permission:create-permission|edit-permission|delete-permission', ['only' => ['index','show']]);
//        $this->middleware('permission:create-permission', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-permission', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }

    public function waiting()
    {
        $inquiries = Inquiry::where(['status' => InquiryStatus::WAITING->value])->get();
        return view('inquiry.waiting', compact('inquiries'));
    }

    public function approved()
    {
        $inquiries = Inquiry::where('status', '>=', InquiryStatus::APPROVED->value)
            ->when(auth()->user()->hasRole('Coordinator'), function ($query){
                return $query->where('assignment_to', auth()->id());
            })->when(auth()->user()->hasRole('Super Admin'), function ($query){
                return $query;
            })
            ->get();
        return view('inquiry.approved', compact('inquiries'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = Inquiry::all();
        return view('inquiry.waiting', compact('inquiries'));
    }

    /**
     *
     *
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
            'country' => $validated['country'],
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

    public function sendFormMail(Request $request)
    {

        $validated = \Validator::make($request->all(), [
            'id' => 'required|exists:inquiries,id'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Inquiry not found']);
        }

        $inquiry = Inquiry::find($request->id);
        $messageTemplate = MessageTemplate::where([
            'treatment_id' => 1, //$inquiry->treatment_id,
            'language_id' => 1, // $inquiry->language_id,
            'type' => 'email_medical_form'
        ])->first();

        if (!$messageTemplate) {
            return response()->json(['status' => 'error', 'message' => 'Message template not found']);
        }

        $user = User::where(['email' => $inquiry->email])->first();

        if ( !$user ) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        $hashKey = Arr::join([$inquiry->id, $inquiry->email, $inquiry->phone], '-');
        $newPassword = Str::random(8);
        $formHash = Str::of(Hash::make($hashKey))->upper()->limit(16, '')->replace('/', 'A')->replace('$', 'B');

        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{patient_name}}', $inquiry->name);
        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{patient_surname}}', $inquiry->surname);
        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{username}}', $inquiry->email);
        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{password}}', $newPassword);
        $messageTemplate->message = Str::of($messageTemplate->message)->replace('{{your_medical_form_link}}', url('/medical-form/show/'. $formHash));

        $medicalForm = MedicalForm::where(['treatment_id' => $inquiry->treatment_id, 'language_id' => $inquiry->language_id])->first();

        if (!$medicalForm) {
            return response()->json(['status' => 'error', 'message' => 'Medical form not found']);
        }

        $html = view('components.backend.inquiries.modal.medical-form-message-for-email',
                            compact('inquiry', 'messageTemplate', 'newPassword', 'user', 'formHash', 'medicalForm'))
                ->render();
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function sendToWhatsapp(Request $request)
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

        $inquiry = Inquiry::find($request->id);
        $user = User::find($request->userId);
        $user->update([
            'password' => Hash::make($request->formHash)
        ]);

        //ready form answers
        MedicalFormPatientAnswers::create([
            'medical_form_id' => $request->medicalFormId,
            'user_id' => $user->id,
            'code' => $request->formHash,
            'answers' => [],
            'last_answers_at' => Carbon::create(Carbon::now())->addDays(3)
        ]);

        return response()->json(['status' => 'success', 'message' => 'Inquiry updated successfully', 'url' => 'https://wa.me/'. $inquiry->phone .'?text='.urlencode($request->message)]);
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

        $html = view('components.backend.inquiries.modal.edit-form', compact('inquiry', 'coordinators', 'treatments', 'languages'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);
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
}
