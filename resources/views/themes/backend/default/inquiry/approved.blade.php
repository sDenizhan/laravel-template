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
                            <a class="nav-link active new_inquiry" href="{{ route('admin.inquiries.create') }}">{{ __('Add New') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="responsible">
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
                                <th>{{ __('Email Address') }}</th>
                                <th>{{ __('Phone Number') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog" aria-labelledby="inquiryModal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" style="color: #fff" id="inquiryModalTitle">Inquiry Details</h4>
                    <button type="button" style="color: #fff" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        url: "{{ route('admin.inquiries.approvedFilters') }}",
                        type: 'POST',
                        data: function (d) {
                            d._token = "{{ csrf_token() }}";
                            d.status = "{{ \App\Enums\InquiryStatus::APPROVED->value }}";
                        }
                    },
                    order : [[1, 'desc']],
                    columns: [
                        {data: 'action', name: 'action'},
                        {data: 'id', name: 'id'},
                        {data: 'name_surname', name: 'name'},
                        {data: 'treatment', name: 'treatment'},
                        {data: 'country', name: 'country'},
                        {data: 'status', name: 'status'},
                        {data: 'coordinator', name: 'coordinator'},
                        {data: 'registration_date', name: 'registration_date'},
                        {data: 'email', name: 'email'},
                        {data: 'phone', name: 'phone'}
                    ],
                    columnDefs : [
                        {
                            targets: 0,
                            data: 'action',
                            sortable: false,
                            render : function (row, type, data) {

                                var allStatus = @json(\App\Enums\InquiryStatus::toArray());
                                var currentStatus = data.status_id;

                                var html = '<div class="btn-group">';
                                html += '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">...</button>';
                                html += '<div class="dropdown-menu">';
                                html += '<a href="#" class="dropdown-item update_status" data-why="not_reached" data-status="'+ allStatus.NOT_REACHED +'" data-id="'+ data.id +'">' +
                                    '<i class="fas fa-phone-slash"></i> {{ __('Not Reachable') }}' +
                                    '</a>' +
                                    '<a href="#" class="dropdown-item update_status" data-why="give_up" data-status="'+ allStatus.GIVE_UP +'" data-id="'+ data.id +'">' +
                                    '<i class="fas fa-user-slash"></i> {{ __('Patient Has Give Up') }} ' +
                                    '</a>';

                                html += '<div class="dropdown-divider"></div>';

                                if (
                                    currentStatus === allStatus.APPROVED ||
                                    currentStatus === allStatus.NOT_REACHED ||
                                    currentStatus === allStatus.GIVE_UP ||
                                    currentStatus === allStatus.FORM_SENT
                                )
                                {

                                    @hasrole('Super Admin|Coordinator')
                                        html += '<a href="#" class="dropdown-item send_form_mail" data-id="'+ data.id +'">' +
                                        '<i class="fas fa-mail-bulk"></i> {{ __('Sent Form via Email') }}' +
                                        '</a>' +
                                        '<a href="#" class="dropdown-item send_form_whatsapp" data-id="'+ data.id +'">' +
                                        '<i class="fas fa-sms"></i> {{ __('Sent Form via Whatsapp') }}' +
                                        '</a>' +
                                        '<a href="#" class="dropdown-item show_medical_form" data-id="'+ data.id +'">'+
                                        '<i class="fa fa-medical"></i> {{ __('Show Medical Form') }}' +
                                        '</a>'+
                                        '<a href="'+ data.medical_form_link +'" class="dropdown-item copy_reference_link" data-id="'+ data.id +'">' +
                                        '<i class="fa fa-link"></i> {{ __('Copy Medical Form Link') }}' +
                                        '</a>';
                                    @endrole
                                }

                                if ( currentStatus >= allStatus.FORM_RECEIVED ) {
                                    html += '<a href="#" class="dropdown-item show_medical_form" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-eye"></i> {{ __('Show Medical Form') }}' +
                                        '</a>';

                                    html += '<a href="#" class="dropdown-item send_to_anesthesia" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-user-md"></i> {{ __('Send to Anaesthetist Doctor') }}' +
                                        '</a>';

                                    html += '<a href="#" class="dropdown-item send_to_doctor" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-user-md"></i> {{ __('Send to Doctor') }}' +
                                        '</a>';
                                }

                                if ( currentStatus === allStatus.ANESTHESIA_SENT ) {

                                }

                                if ( currentStatus === allStatus.ANESTHESIA_ACCEPTED ) {
                                    html += '<a href="#" class="dropdown-item send_to_anesthesia" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-user-md"></i> {{ __('Send to Anaesthetist Doctor') }}' +
                                        '</a>';

                                    html += '<a href="#" class="dropdown-item send_to_doctor" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-user-md"></i> {{ __('Send to Doctor') }}' +
                                        '</a>';
                                }

                                if ( currentStatus === allStatus.ANESTHESIA_REJECTED ) {

                                }

                                if ( currentStatus === allStatus.DOCTOR_ACCEPTED ) {
                                    html += '<a href="#" class="dropdown-item make_treatment_schedule" data-id="'+ data.id +'">'+
                                        '<i class="fas fa-user-md"></i> {{ __('Make Treatment Schedule') }}' +
                                        '</a>';
                                }

                                if ( currentStatus === allStatus.DOCTOR_REJECTED ) {

                                }

                                if (currentStatus === allStatus.DOCTOR_SENT) {

                                }

                                html += '<div class="dropdown-divider"></div>';

                                @can('edit-inquiry')
                                    html += '<a href="#" class="dropdown-item show_inquiry" data-id="'+ data.id +'"><i class="fas fa-eye"></i> {{ __('Show')  }}</a>';
                                @endcan

                                @can('view-inquiry')
                                    var viewURL = "{{ route('admin.inquiries.show', ':id') }}".replace(':id', data.id);
                                    html += '<a href="'+ viewURL +'" class="dropdown-item" data-id="'+ data.id +'"><i class="fas fa-mail-bulk"></i> {{ __('Show Inquiry') }}</a>';
                                @endcan

                                @can('edit-inquiry')
                                    html += '<a href="#" class="dropdown-item cancellation" data-id="'+ data.id +'"><i class="fas fa-trash"></i> {{ __('Cancel') }}</a>';
                                @endcan

                                html += '</div></div>';
                                html += '</div>';
                                return html;
                            }
                        },
                        {
                            target: 2,
                            sortable: false,
                        },
                        {
                            targets: 5,
                            data: 'status',
                            render : function (row, type, data) {

                                switch (row) {
                                    case 'APPROVED':
                                        return '<span class="badge badge-soft-success">'+ row +'</span>';
                                    case 'NOT_REACHED':
                                        return '<span class="badge badge-soft-danger">'+ row +'</span>';
                                    case 'GIVE_UP':
                                        return '<span class="badge badge-soft-warning">'+ row +'</span>';
                                    case 'FORM_SENT':
                                        return '<span class="badge badge-soft-info">'+ row +'</span>';
                                }

                                return '<span class="badge badge-soft-success">'+ row +'</span>';
                            }
                        },
                        {
                            targets: 4,
                            data: 'country',
                            render : function (row, type, data) {
                                return row.length > 15 ? row.slice(0, 15)+'...' : row;
                            }
                        },
                        {
                            targets: 6,
                            visible: false,
                        }
                    ]
                });


            //on hide remove class
            $('#inquiryModal').on('hidden.bs.modal', function () {
                $('#inquiryModal .modal-footer').find('button.btn-primary')
                    .removeClass('email_send')
                    .removeClass('wh_send')
                    .removeClass('save_inquiry')
                    .removeClass('send_to_anaesthesia');
            });

            $(document).on('click', 'a.make_treatment_schedule', function (e){
                e.preventDefault();

                let id = $(this).data('id');
                let url = '{{ route('admin.inquiries.make-schedule', ['inquiryId' => ':inquiryId']) }}';
                url = url.replace(':inquiryId', id)

                window.location.href = url;
            });

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

            //summernote
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

                $.post('{{ route('admin.inquiries.get-inquiry-message-template') }}', {
                    id: id,
                    function : 'email',
                    _token : '{{ csrf_token() }}',
                    _method: 'POST',
                }, function(response) {
                    if ( response.status === 'success') {
                        $('#inquiryModal .modal-body').html(response.html);
                        $('.subject').remove();
                        $('#inquiryModal .modal-footer').find('button.btn-primary').addClass('email_send').text('Send');
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

            //mail sending
            $(document).on('click', '.email_send', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var data = $('#inquiryModalForm').serialize();

                console.log(data);

                $('h4.modal-title').text('Send Form Mail');

                $.post('{{ route('api.admin.emails.medical-form-sending-with-email') }}', data, function(response) {
                    if ( response.status === 'success') {
                        Swal.fire(
                            '{{ __('Success!') }}',
                            '{{ __('Inquiry has been sent to email.') }}',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            '{{ __('Error!') }}',
                            '{{ __('Something went wrong!') }}',
                            'error'
                        );
                    }
                });

                $('#inquiryModal .modal-footer').find('button.btn-primary').removeClass('email_send');
            });

            //send form whatsapp
            $(document).on('click', '.send_form_whatsapp', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $('h4.modal-title').text('Send Form Whatsapp');

                $.post('{{ route('admin.inquiries.get-inquiry-message-template') }}', {
                    id: id,
                    function : 'whatsapp',
                    _token : '{{ csrf_token() }}',
                    _method: 'POST',
                }, function(response) {
                    if ( response.status === 'success') {
                        $('#inquiryModal .modal-body').html(response.html);
                        $('.subject').remove();
                        $('#inquiryModal .modal-footer').find('button').removeClass('email_send').removeClass('save_inquiry').addClass('wh_send').text('Send');
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


            //new inquiry run modal
            $(document).on('click', '.new_inquiry', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $('h4.modal-title').text('New Inquiry');

                $.get(url, function(response) {
                    $('#inquiryModal .modal-body').html(response.html);
                    $('#inquiryModal').modal('show');
                    $('#inquiryModal .modal-footer').find('button.btn-primary').removeClass('email_send').removeClass('wh_send').addClass('save_inquiry').text('Send');
                });
            });


            $(document).on('keyup', ' input#name', function(e) {
                e.preventDefault();
                var name = $(this).val();

                if (name.length > 3) {
                    $.post('{{ route('admin.inquiries.findCustomer') }}', {
                        _method : 'POST',
                        _token : '{{ csrf_token() }}',
                        name: name
                    },
                    function(response) {
                        if (response.status === 'success') {
                            var list = '';
                            for( var i = 0; i <= response.users.length-1; i++) {
                                var data = response.users[i];
                                list += '<li class="list-group-item" data-id="'+ data.id +'"><a href="#" class="select">'+ data.name + '</a></li>';
                            }
                            $('#inquiryModal .modal-body').find('div.results > ul').html(list);
                            $('div.results').fadeIn();
                        }
                    });
                }
            });

            $(document).on('click', 'a.select', function(e) {
                e.preventDefault();
                var id = $(this).parent().data('id');
                var name = $(this).text();

                var data = {
                    id: id,
                    name: name,
                    _token : '{{ csrf_token() }}',
                    _method : 'POST'
                };

                $.post('{{ route('admin.inquiries.find-inquiry') }}', data, function (response){
                    if ( response.status === 'success' ) {
                        var inquiry = response.inquiry;
                        $('#inquiryModal').find('input#name').val(inquiry.name);
                        $('#inquiryModal').find('input#surname').val(inquiry.surname);
                        $('#inquiryModal').find('input#email').val(inquiry.email);
                        $('#inquiryModal').find('input#phone').val(inquiry.phone);
                        $('#inquiryModal').find('input#country').val(inquiry.country);
                        $('#inquiryModal').find('select#treatment_id').val(inquiry.treatment_id);
                        $('#inquiryModal').find('select#language_id').val(inquiry.language_id);
                        $('div.results').fadeOut();
                    }
                })
            });

            //copy reference link
            $(document).on('click', '.copy_reference_link', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');

                var dummy = document.createElement('input'),
                    text = url;

                document.body.appendChild(dummy);
                dummy.value = text;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);

                Swal.fire(
                    '{{ __('Copied!') }}',
                    '{{ __('Reference link has been copied to clipboard.') }}',
                    'success'
                );
            });

            //sent to doctors
            $(document).on('click', '.send_to_anesthesia', function (e){
                e.preventDefault();

                var id = $(this).data('id');
                $('h4.modal-title').text('Send to Anaesthesia');

                $.get('{{ route('api.admin.doctors.get') }}', {
                    id: id,
                    _token : '{{ csrf_token() }}',
                    _method: 'GET',
                    role : 'Anaesthetist'
                }, function(response) {
                    if ( response.status === 'success') {

                        var doctors = response.data;
                        var options = '<select name="doctor_id[]" id="doctor_id" placeholder="Deneme" multiple class="form-control select2">';
                        for (var i = 0; i <= doctors.length-1; i++) {
                            var doctor = doctors[i];
                            options += '<option value="'+ doctor.id +'">'+ doctor.name +'</option>';
                        }
                        options += '</select>';

                        var html = '<div class="form-group"><label for="doctor_id" class="form-label">{{ __('Select Anaesthesia') }}</label>'+ options +'</div>';
                        html += '<input type="hidden" name="inquiry_id" value="'+ id +'">';
                        $('#inquiryModal .modal-body').html(html);

                        $('#inquiryModal .modal-body').find('select#doctor_id').select2({
                            placeholder: {
                                id: '-1',
                                text: 'Select Anaesthesia'
                            }
                        }).trigger('change');

                        $('#inquiryModal .modal-footer').find('button.btn-primary').addClass('send_to_anaesthesia').text('Send');
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

            //send to anesthesia
            $(document).on('click', 'button.send_to_anaesthesia', function (e){
                e.preventDefault();

                var data = $('#inquiryModalForm').serialize();

                $.post('{{ route('admin.doctors.send_to_anaesthesia') }}', data, function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            '{{ __('Success!') }}',
                            '{{ __('Inquiry has been sent to anaesthesia.') }}',
                            'success'
                        );
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

            //sent to doctors
            $(document).on('click', '.send_to_doctor', function (e){
                e.preventDefault();

                var id = $(this).data('id');
                $('h4.modal-title').text('Send to Doctor');

                $.get('{{ route('api.admin.doctors.get') }}', {
                    id: id,
                    _token : '{{ csrf_token() }}',
                    _method: 'GET',
                    role : 'Doctor'
                }, function(response) {
                    if ( response.status === 'success') {

                        var doctors = response.data;
                        var options = '<select name="doctor_id[]" id="doctor_id" placeholder="" multiple class="form-control select2">';
                        for (var i = 0; i <= doctors.length-1; i++) {
                            var doctor = doctors[i];
                            options += '<option value="'+ doctor.id +'">'+ doctor.name +'</option>';
                        }
                        options += '</select>';

                        var html = '<div class="form-group"><label for="doctor_id" class="form-label">{{ __('Select Doctor') }}</label>'+ options +'</div>';
                        html += '<input type="hidden" name="inquiry_id" value="'+ id +'">';
                        $('#inquiryModal .modal-body').html(html);

                        $('#inquiryModal .modal-body').find('select#doctor_id').select2({
                            placeholder: {
                                id: '-1',
                                text: 'Select Doctor'
                            }
                        }).trigger('change');

                        $('#inquiryModal .modal-footer').find('button.btn-primary').addClass('send_to_doctor').text('Send');
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

            //send to doctor
            $(document).on('click', 'button.send_to_doctor', function (e){
                e.preventDefault();

                var data = $('#inquiryModalForm').serialize();

                $.post('{{ route('admin.doctors.send_to_doctor') }}', data, function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            '{{ __('Success!') }}',
                            '{{ __('Inquiry has been sent to doctor.') }}',
                            'success'
                        );
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

            //save
            $(document).on('click', '.save_inquiry', function(e) {
                e.preventDefault();
                var form = $('#inquiryModalForm');
                var url = form.attr('action');
                var data = form.serialize();

                $.post(url, data, function(response) {
                    if (response.status === 'success') {
                        $('#inquiryModal').find('div.modal-body > div.row').after('<div class="row"><div class="alert alert-success"><p>'+ response.message +'</p></div></div>')
                    } else {
                        $('#inquiryModal').find('div.modal-body').append('div.alert.alert-danger').empty().html('<p>' + response.message + '</p>');
                    }

                    $('#inquiryModal > .model-footer').find('button.btn-primary').removeClass('save_inquiry');
                });
            });

        });
    </script>
@endpush

