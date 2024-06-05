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
                                    <a href="{{ route('admin.inquiries.edit', $inquiry->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> </a>
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
@endpush
