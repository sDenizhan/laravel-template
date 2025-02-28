@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Inquiries'),
                'url' => route('admin.inquiries.anaesthetist')
            ],
            [
                'title' => __('Index'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Inquiries') }}" :links="$data"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <table id="datatable" class="table dt-responsive nowrap w-100">
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
                <form method="post" action="{{ route('inquiries.store') }}" id="inquiryModalForm">
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

    <!-- Select 2 -->
    <link href="{{ asset('themes/backend/default/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">

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

    <!-- Select 2 -->
    <script src="{{ asset('themes/backend/default/assets/libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            var table = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.inquiries.doctorFilters') }}",
                        type: 'POST',
                        data: function (d) {
                            d._token = "{{ csrf_token() }}";
                            d.status = "{{ \App\Enums\InquiryStatus::DOCTOR_SENT->value }}";
                        }
                    },
                    columns: [
                        {data: 'action', name: 'action'},
                        {data: 'id', name: 'id'},
                        {data: 'name_surname', name: 'name'},
                        {data: 'treatment', name: 'treatment'},
                        {data: 'country', name: 'country'},
                        {data: 'status', name: 'status'},
                        {data: 'coordinator', name: 'coordinator'},
                        {data: 'registration_date', name: 'registration_date'},
                    ],
                    columnDefs : [
                        {
                            targets: 0,
                            data: 'action',
                            render : function (row, type, data) {

                                let html = '<div class="btn-group">';
                                    html += '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">...</button>';
                                    html += '<div class="dropdown-menu">';
                                    html += '<a href="#" class="dropdown-item show_medical_form" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-eye"></i> {{ __('Show Medical Form') }}' +
                                        '</a>';
                                    html += '<a href="#" class="dropdown-item change_status" data-status="{{ \App\Enums\InquiryStatus::DOCTOR_ACCEPTED->value }}" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-thumb-up"></i> {{ __('Approve') }}' +
                                        '</a>';
                                    html += '<a href="#" class="dropdown-item change_status" data-status="{{ \App\Enums\InquiryStatus::DOCTOR_REJECTED->value }}" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-thumb-down"></i> {{ __('Reject') }}' +
                                        '</a>';
                                    html += '</div></div>';
                                    html += '</div>';
                                return html;
                            }
                        }
                    ]
                });

            //show medical form
            $(document).on('click', '.show_medical_form', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let url = '{{ route('admin.inquiries.view-medical-form', ':id') }}'.replace(':id', id);

                //redirect to medical form
                window.open(url, '_blank').focus();
            });

            //change status
            $(document).on('click', '.change_status', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let status = $(this).data('status');
                let url = '{{ route('admin.inquiries.statusUpdate') }}';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: 'POST',
                        id : id,
                        status : status
                    },
                    success: function (response) {
                        if (response.status) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    }
                });
            });

        });
    </script>
@endpush
