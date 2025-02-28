<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InquiryStatus;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ( auth()->user()->hasRole('Super Admin') ) {
            $latest = Inquiry::with(['coordinator'])->orderBy('created_at', 'desc')->limit(10)->latest()->get();

            $userInquiries = Inquiry::with(['coordinator'])->where('status', '>=', InquiryStatus::APPROVED->value);

            if ( auth()->user()->hasRole('Coordinator') ) {
                $userInquiries->where('assignment_to', auth()->user()->id);
            }

            $userInquiries = $userInquiries->latest()->limit(10)->get();
        } else {
            $latest = [];
            $userInquiries = [];
        }

        return view('dashboard.home', compact('latest', 'userInquiries'));
    }
}
