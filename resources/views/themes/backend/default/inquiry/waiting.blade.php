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

<x-backend.inquiries.table.filters />

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>{{ __('Actions') }}</th>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name Surname') }}</th>
                            <th>{{ __('Registration Date') }}</th>
                            <th>{{ __('Treatment') }}</th>
                            <th>{{ __('Country') }}</th>
                            <th>{{ __('Referenced By') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog" aria-labelledby="inquiryModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="inquiryModalTitle" style="color: #ebebeb">Inquiry Details</h4>
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

    <script>
        $(document).ready(function(){

            var table = $('#basic-datatable').DataTable({
                processing: true,
                serverSide: true,
                dom : '<"row">rt<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4"i><"col-sm-12 col-md-4"p>>',
                ajax: {
                    url: "{{ route('api.admin.inquiries.waiting') }}",
                    type: 'POST',
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = "{{ \App\Enums\InquiryStatus::WAITING->value }}";
                        d.treatment = $('select#treatment').val();
                        d.country = $('select#country').val();
                        d.id = $('input#id').val();
                        d.query = $('input#query').val();
                        d.coordinator = $('select[name=coordinator]').val();
                        d.start_date = $('input#start_date').val();
                        d.end_date = $('input#end_date').val();
                        d.language = $('select#language').val();
                    }
                },
                columns: [
                    {data: 'action', name: 'action'},
                    {data: 'id', name: 'id'},
                    {data: 'name_surname', name: 'name'},
                    {data: 'registration_date', name: 'registration_date'},
                    {data: 'treatment', name: 'treatment'},
                    {data: 'country', name: 'country'},
                    {data: 'reference', name: 'referenced_by'},
                ],
                columnDefs : [
                    {
                        targets: 0,
                        data: 'action',
                        render : function (row, type, data) {
                            var html = '<div class="btn-group">';
                            html += '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">...</button>';
                            html += '<div class="dropdown-menu">';
                            @can('edit-inquiry')
                                html += '<a href="#" class="dropdown-item show_inquiry" data-id="'+ data.id +'"><i class="fas fa-eye"></i> {{ __('Show')  }}</a>';
                            @endcan

                            @can('edit-inquiry')
                                html += '<a href="#" class="dropdown-item cancellation" data-id="'+ data.id +'"><i class="fas fa-trash"></i> {{ __('Cancel') }}</a>';
                            @endcan

                            html += '</div></div>';
                            html += '</div>';

                            return html;
                        }
                    }
                ]
            });

            //ajax reload on treatment change
            $('select').on('change', function() {
                table.ajax.reload();
            });

            //search
            $(document).on('keyup', 'input', function(e) {
                e.preventDefault();

                if ( $(this).attr('id') === 'id') {
                    table.ajax.reload();
                }
                else if ( $(this).val().length > 2 || $(this).val().length === 0) {
                    table.ajax.reload();
                }
            });

            //
            $(document).on('click', '.show_inquiry', function(e) {
                e.preventDefault();
                var url = '{{ route('admin.inquiries.update', ['inquiry' => 'inquiryId']) }}';
                var id = $(this).data('id');
                url = url.replace('inquiryId', id);

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
                    if (response.status === 'success') {
                        $('#inquiryModal').find('div.modal-body > div.row').after('<div class="row"><div class="alert alert-success"><p>'+ response.message +'</p></div></div>');

                        setTimeout(function() {
                            $('#inquiryModal').modal('hide');
                            table.ajax.reload();
                        }, 1000);
                    } else {
                        $('#inquiryModal').find('div.modal-body').append('div.alert.alert-danger').empty().html('<p>' + response.message + '</p>');
                    }
                });
            });
        });
    </script>
@endpush
