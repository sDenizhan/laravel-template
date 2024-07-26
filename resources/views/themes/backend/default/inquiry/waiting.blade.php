@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Waiting Inquiries'),
                'url' => route('admin.inquiries.index')
            ],
            [
                'title' => __('Index'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Waiting Inquiries') }}" :links="$data" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.inquiries.create') }}">{{ __('Add New') }}</a>
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
                            <th>{{ __('Coordinator') }}</th>
                            <th>{{ __('Registration Date') }}</th>
                            <th>{{ __('Treatment') }}</th>
                            <th>{{ __('Country') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquiries as $inquiry)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.inquiries.update', $inquiry->id) }}" class="btn btn-sm btn-primary show_inquiry" data-id="{{ $inquiry->id }}"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> </a>
                                    <a href="{{ route('admin.inquiries.rejected', ['inquiryId' => $inquiry->id]) }}" class="btn btn-sm btn-danger cancellation"><i class="fas fa-trash"></i></a>
                                </td>
                                <td>{{ $inquiry->id }}</td>
                                <td>{{ $inquiry->name.' '. $inquiry->surname }}</td>
                                <td>{{ $inquiry->assigment_to ?? $inquiry->coordinator->name ?? '-' }}</td>
                                <td>{{ $inquiry->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $inquiry->treatment->name }}</td>
                                <td>{{ $inquiry->country }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog" aria-labelledby="inquiryModal" aria-hidden="true">
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
 <link href="{{ asset('themes/backend/default/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('themes/backend/default/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('themes/backend/default/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('themes/backend/default/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('themes/backend/default/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
 <!-- third party css end -->
@endpush

@push('scripts')
    <!-- third party js -->
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src=" {{ asset('themes/backend/default/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src=" {{ asset('themes/backend/default/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('themes/backend/default/assets/js/pages/fontawesome.init.js') }}"></script>

    <script>
        $(document).ready(function(){
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

            //cancellation
            $(document).on('click', '.cancellation', function(e) {
                e.preventDefault();
                $('h4.modal-title').text('Reason For Cancellation');
                var html = '<div class="form-group"><label for="reason" class="form-label">Reason For Cancellation</label><textarea class="form-control" name="cancel" id="cancel" rows="3"></textarea></div>';

                $('#inquiryModal .modal-body').html(html);
                $('#inquiryModal').modal('show');
            });

            //save
            $(document).on('click', '.save_inquiry', function(e) {
                e.preventDefault();
                var form = $('#inquiryModalForm');
                var url = form.attr('action');
                var data = form.serialize();

                $.post(url, data, function(response) {
                    if (response.status == 'success') {
                        $('#inquiryModal').find('div.modal-body > div.row').after('<div class="row"><div class="alert alert-success"><p>'+ response.message +'</p></div></div>')
                    } else {
                        $('#inquiryModal').find('div.modal-body').append('div.alert.alert-danger').empty().html('<p>' + response.message + '</p>');
                    }
                });
            });
        });
    </script>
@endpush
