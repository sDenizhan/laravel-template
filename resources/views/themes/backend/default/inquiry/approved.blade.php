@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Approved Inquiries'),
                'url' => route('admin.inquiries.index')
            ],
            [
                'title' => __('Index'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Approved Inquiries') }}" :links="$data"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="{{ route('admin.inquiries.create') }}">{{ __('Add New') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>{{ __('Actions') }}</th>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name Surname') }}</th>
                            <th>{{ __('Treatment') }}</th>
                            <th>{{ __('Country') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Coordinator') }}</th>
                            <th>{{ __('Registration Date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inquiries as $inquiry)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">...
                                            </button>
                                            <div class="dropdown-menu">

                                                @if ($inquiry->status == \App\Enums\InquiryStatus::APPROVED->value ||
                                                    $inquiry->status == \App\Enums\InquiryStatus::NOT_REACHED->value ||
                                                    $inquiry->status == \App\Enums\InquiryStatus::GIVE_UP->value ||
                                                    $inquiry->status == \App\Enums\InquiryStatus::FORM_SENT->value )

                                                    @hasrole('Super Admin|Coordinator')
                                                        <a href="#" class="dropdown-item update_status" data-why="not_reached" data-status="{{ \App\Enums\InquiryStatus::NOT_REACHED->value }}" data-id="{{ $inquiry->id }}">
                                                            <i class="fas fa-phone-slash"></i> {{ __('Not Reachable') }}
                                                        </a>

                                                        <a href="#" class="dropdown-item update_status" data-why="give_up" data-status="{{ \App\Enums\InquiryStatus::GIVE_UP->value }}" data-id="{{ $inquiry->id }}">
                                                            <i class="fas fa-user-slash"></i> {{ __('Patient Has Give Up') }}
                                                        </a>

                                                        <a href="#" class="dropdown-item send_form_mail" data-id="{{ $inquiry->id }}">
                                                            <i class="fas fa-mail-bulk"></i> {{ __('Sent Form via Email') }}
                                                        </a>

                                                        <a href="#" class="dropdown-item send_form_whatsapp" data-id="{{ $inquiry->id }}">
                                                            <i class="fas fa-sms"></i> {{ __('Sent Form via Whatsapp') }}
                                                        </a>
                                                    @endrole

                                                @endif

                                                @if ($inquiry->status === \App\Enums\InquiryStatus::DOCTOR_SENT->value )

                                                @endif

                                                @can('edit-inquiry')
                                                    <a href="{{ route('admin.inquiries.update', $inquiry->id) }}"
                                                       class="dropdown-item show_inquiry" data-id="{{ $inquiry->id }}">
                                                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                                                    </a>
                                                @endcan

                                                @can('view-inquiry')
                                                    <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" data-id="{{ $inquiry->id }}"
                                                       class="dropdown-item show_inquiry">
                                                        <i class="fas fa-eye"></i> {{ __('View') }}
                                                    </a>
                                                @endcan

                                                @can('delete-inquiry')
                                                    <a href="{{ route('admin.inquiries.rejected', ['inquiryId' => $inquiry->id]) }}"
                                                       class="dropdown-item cancellation">
                                                        <i class="fas fa-trash"></i> {{ __('Cancel') }}
                                                    </a>
                                                @endcan

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $inquiry->id }}</td>
                                <td>{{ $inquiry->name.' '. $inquiry->surname }}</td>
                                <td>{{ $inquiry->treatment->name }}</td>
                                <td>{{ $inquiry->country }}</td>
                                <td>{{ __(\App\Enums\InquiryStatus::from($inquiry->status)->getLabel() ) }}</td>
                                <td>{{ $inquiry->coordinator->name }}</td>
                                <td>{{ $inquiry->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog" aria-labelledby="inquiryModal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="inquiryModalTitle">Inquiry Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('admin.inquiries.store') }}" id="inquiryModalForm">
                    @csrf
                    @method('POST')
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save_inquiry">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- third party css -->
    <link href="{{ asset('themes/backend/default/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('themes/backend/default/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('themes/backend/default/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('themes/backend/default/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link href="{{ asset('themes/backend/default/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- third party css end -->
    <link href="{{ asset('themes/backend/default/assets/libs/summernote/summernote.css') }}" rel="stylesheet" type="text/css">

    <!-- Sweet Alert-->
    <link href="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
    <!-- third party js -->
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script
        src=" {{ asset('themes/backend/default/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <script src="{{ asset('themes/backend/default/assets/libs/summernote/summernote.min.js') }}"></script>

    <!-- Datatables init -->
    <script src=" {{ asset('themes/backend/default/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('themes/backend/default/assets/js/pages/fontawesome.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            //update status
            $(document).on('click', '.update_status', function (e){
                e.preventDefault();

                let id = $(this).data('id');
                let status = $(this).data('status');

                Swal.fire({
                    title : '{{ __('Are You Sure?') }}',
                    text : '{{ __('You will not be able to revert this!') }}',
                    icon : 'warning',
                    showCancelButton : true,
                    confirmButtonColor : '#34c38f',
                    cancelButtonColor : '#f46a6a',
                    confirmButtonText : '{{ __('Yes') }}',
                    cancelButtonText : '{{ __('No!') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('{{ route('admin.inquiries.statusUpdate') }}', {
                            id: id,
                            _token : '{{ csrf_token() }}',
                            _method: 'POST',
                            status: status
                        }, function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    '{{ __('Not Reachable!') }}',
                                    '{{ __('Inquiry has been marked as not reachable.') }}',
                                    'success'
                                );

                               location.reload();
                            } else {
                                Swal.fire(
                                    '{{ __('Error!') }}',
                                    '{{ __('Something went wrong!') }}',
                                    'error'
                                );
                            }
                        });
                    }
                });

            });

            //summernote
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            //show inquiry
            $(document).on('click', '.show_inquiry', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');

                $('h4.modal-title').text('Inquiry Details');

                $.get(url, {id: id}, function(response) {
                    $('#inquiryModal .modal-body').html(response.html);
                    $('#inquiryModal').modal('show');
                });
            });

            $('#inquiryModal').on('shown.bs.modal', function () {
                $('.summernote').summernote({
                    height: 450,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });

            //send form mail
            $(document).on('click', '.send_form_mail', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $('h4.modal-title').text('Send Form Mail');

                $.post('{{ route('admin.inquiries.send_form_mail') }}', {
                    id: id,
                    _token : '{{ csrf_token() }}',
                    _method: 'POST',
                }, function(response) {
                    $('#inquiryModal .modal-body').html(response.html);
                    $('#inquiryModal').modal('show');
                });
            });

            //send form whatsapp
            $(document).on('click', '.send_form_whatsapp', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $('h4.modal-title').text('Send Form Whatsapp');

                $.post('{{ route('admin.inquiries.send_form_mail') }}', {
                    id: id,
                    _token : '{{ csrf_token() }}',
                    _method: 'POST',
                }, function(response) {
                    if ( response.status == 'success') {
                        $('#inquiryModal .modal-body').html(response.html);
                        $('.subject').remove();
                        $('#inquiryModal .modal-footer').find('button.save_inquiry').addClass('wh_send').text('Send');
                        $('#inquiryModal').modal('show');
                    } else {
                        Swal.fire(
                            '{{ __('Error!') }}',
                            response.message,
                            'error'
                        );
                    }
                });
            });

            //send form whatsapp
            $(document).on('click', '.wh_send', function (e){
                e.preventDefault();

                var data = $('#inquiryModalForm').serialize();

                $.post('{{ route('admin.inquiries.send_to_whatsapp') }}', data, function(response) {
                    if (response.status === 'success') {
                        window.open(response.url, '_blank').focus();
                        $('#inquiryModal').modal('hide');
                    } else {
                        Swal.fire(
                            '{{ __('Error!') }}',
                            '{{ __('Something went wrong!') }}',
                            'error'
                        );
                    }
                });
            });

            //cancellation
            $(document).on('click', '.cancellation', function (e) {
                e.preventDefault();
                $('h4.modal-title').text('Reason For Cancellation');
                var html = '<div class="form-group"><label for="reason" class="form-label">Reason For Cancellation</label><textarea class="form-control" name="cancel" id="cancel" rows="3"></textarea></div>';

                $('#inquiryModal .modal-body').html(html);
                $('#inquiryModal').modal('show');
            });

        });
    </script>
@endpush
