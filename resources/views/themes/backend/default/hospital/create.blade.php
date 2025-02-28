@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Hospitals'),
                'url' => route('admin.hospitals.index')
            ],
            [
                'title' => __('Add New'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Add New') }}" :links="$data" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('api.admin.hospitals.store') }}" method="POST" id="hospital-create-form">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Hospital Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <textarea name="address" id="address" class="form-control" placeholder="{{ __('Address') }}">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="statusx" class="form-label">{{ __('Status') }}</label>
                        <select name="status" id="statusx" class="form-control">
                            @php
                                $status = App\Enums\Status::toArray();
                                foreach ($status as $key => $value) {
                                    echo '<option value="'. $key .'">'. $value .'</option>';
                                }
                            @endphp
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="doctors" class="form-label">{{ __('Doctors') }}</label>
                        <select name="doctors[]" id="doctors" class="form-control select2" multiple>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctors')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">{{ __('Anaesthetists') }}</label>
                        <select name="anaesthetists[]" id="anaesthetists" class="form-control select2" multiple>
                            @foreach ($anaesthetists as $anaesthetist)
                                <option value="{{ $anaesthetist->id }}">{{ $anaesthetist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('themes/backend/default/assets/libs/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/backend/default/assets/libs/select2/css/select2.min.css') }}">
    <!-- Sweet Alert -->
    <link href="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                multiple: true,
            });

            $('#hospital-create-form').on('submit', function(e){
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                $.post(url, form.serialize(), function(response){
                    if (response.status == 'success') {
                        //sweet alert success
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                        form.trigger('reset');
                    } else {
                        //sweet alert error
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            })
        });
    </script>
@endpush
