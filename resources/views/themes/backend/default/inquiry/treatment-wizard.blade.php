@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Inquiries'),
                'url' => route('admin.inquiries.approved')
            ],
            [
                'title' => __('Index'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Make Treatment Schedule') }}" :links="$data"/>
@endsection

@section('content')
    @php($currencies = \App\Enums\Currencies::toArray())
    @php($airports = \App\Enums\Airports::toArray())
    @php($hospitals = \App\Models\Hospital::all())
    @php($doctors = \App\Models\User::role('doctor')->get())

    <div class="row mt-2">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        @csrf
                        @method('POST')
                        <input type="hidden" name="inquiry_id" value="{{ $inquiry->id }}">
                        <input type="hidden" name="patient_id" value="{{ $inquiry->user_id }}">
                        <input type="hidden" name="treatment_id" value="{{ $inquiry->treatment_id }}">
                        <div id="basicwizard">
                            <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-4">
                                <li class="nav-item">
                                    <a href="#basictab1" data-bs-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span class="d-none d-sm-inline">Payment</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#basictab2" data-bs-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-face-profile me-1"></i>
                                        <span class="d-none d-sm-inline">Ticket Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#basictab3" data-bs-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>
                                        <span class="d-none d-sm-inline">Calendar</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#basictab4" data-bs-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                        <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>
                                        <span class="d-none d-sm-inline">Program</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0 pt-0">

                                <div class="tab-pane" id="basictab1">
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">{{ __('Total Amount') }}</label>
                                            <input type="number" class="form-control" name="total_amount" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('Currency') }}</label>
                                            <select class="form-select" name="currenyId" required>
                                                @foreach($currencies as $id => $currency)
                                                    <option value="{{ $id }}">{{ $currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Deposit Required?') }}</label>
                                            <select class="form-select" name="deposit_is_required" required>
                                                <option value="yes">{{ __('Yes') }}</option>
                                                <option value="no">{{ __('No') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">{{ __('Required Deposit') }}</label>
                                            <input type="number" class="form-control" name="required_deposit">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('Currency') }}</label>
                                            <select class="form-select" name="depositCurrencyId">
                                                @foreach($currencies as $id => $currency)
                                                    <option value="{{ $id }}">{{ $currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">{{ __('Paid Deposit') }}</label>
                                            <input type="number" class="form-control" name="paid_deposit">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('Currency') }}</label>
                                            <select class="form-select" name="paidCurrencyId">
                                                @foreach($currencies as $id => $currency)
                                                    <option value="{{ $id }}">{{ $currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Payment Date') }}</label>
                                            <input type="date" class="form-control" name="payment_date">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Payment Method') }}</label>
                                            <select class="form-select" name="payment_method">
                                                <option value="BANK">{{ __('BANK') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="basictab2">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Will Patient Upload Ticket?') }}</label>
                                            <select class="form-select" name="will_upload_ticket" required>
                                                <option value="yes">{{ __('Yes') }}</option>
                                                <option value="no">{{ __('No') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Arrival Airport') }}</label>
                                            <select class="form-select" name="arrival_airport">
                                                @foreach($airports as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Flight Number') }}</label>
                                            <input type="text" class="form-control" name="arrival_flight_no">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Arrival Date') }}</label>
                                            <input type="datetime-local" class="form-control" name="arrival_date">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Departure Airport') }}</label>
                                            <select class="form-select" name="departure_airport">
                                                @foreach($airports as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Flight Number') }}</label>
                                            <input type="text" class="form-control" name="departure_flight_no">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Departure Date') }}</label>
                                            <input type="datetime-local" class="form-control" name="departure_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="basictab3">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Hospital') }}</label>
                                            <select class="form-select" name="hospital_id" required>
                                                @foreach($hospitals as $hospital)
                                                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Doctor') }}</label>
                                            <select class="form-select" name="doctor_id" required>
                                                @foreach($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Notes') }}</label>
                                            <textarea class="form-control" name="notes" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Operation Date') }}</label>
                                            <input type="datetime-local" class="form-control" name="operation_date" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="basictab4">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Pre-operation Instructions') }}</label>
                                            <textarea class="form-control" name="pre_op_instructions" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Important Information') }}</label>
                                            <textarea class="form-control" name="important_info" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Files') }}</label>
                                            <select class="form-select" name="files[]" multiple>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <ul class="list-inline wizard mb-0">
                                    <li class="list-inline-item">
                                        <a href="#" class="btn btn-secondary btn-pre">Previous</a>
                                    </li>
                                    <li class="list-inline-item float-end">
                                        <a href="#" class="btn btn-secondary btn-next">Next</a>
                                    </li>
                                </ul>

                            </div> <!-- tab-content -->
                        </div> <!-- end #basicwizard-->
                    </form>

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection

@push('styles')
    <link href="{{ asset('themes/backend/default/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endpush


@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $("#basicwizard").bootstrapWizard();

            $('.btn-next').on('click', function(e) {
                e.preventDefault();
                let maxTab = $('.nav-pills.nav-justified').find('li').length;
                let currentId = $('.tab-pane.active').attr('id');
                let nextId = currentId.replace('basictab', '');
                nextId = parseInt(nextId) + 1;

                if ( nextId <= maxTab ) {
                    $('#'+currentId).removeClass('active').removeClass('show').fadeOut();
                    $('#basictab'+nextId).addClass('active').addClass('show').fadeIn();

                    $('a.nav-link').removeClass('active').each(function(){
                        if ( $(this).attr('href') === '#basictab'+nextId ) {
                            $(this).addClass('active');
                        }
                    });
                }

                if ( nextId === maxTab ) {
                    $('.btn-next').text('Finish');
                    $('.btn-next').on('click', function(e) {
                        e.preventDefault();
                        let url = '{{ route('admin.inquiries.treatment.store', $inquiry->id) }}';
                        $.post(url, $('form').serialize(), function(response) {
                            if ( response.status === 'success' ) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    });
                }

            });

            $('.btn-pre').on('click', function(e) {
                e.preventDefault();
                let currentId = $('.tab-pane.active').attr('id');
                let preId = currentId.replace('basictab', '');
                preId = parseInt(preId) - 1;

                if ( preId >= 1 ) {
                    $('#'+currentId).removeClass('active').removeClass('show').fadeOut();
                    $('#basictab'+preId).addClass('active').addClass('show').fadeIn();

                    $('a.nav-link').removeClass('active').each(function(){
                        if ( $(this).attr('href') === '#basictab'+preId ) {
                            $(this).addClass('active');
                        }
                    });
                }
            });

        });
    </script>
@endpush
