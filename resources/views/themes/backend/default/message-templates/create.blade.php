@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Message Templates'),
                'url' => route('admin.message-template.index')
            ],
            [
                'title' => __('Add New'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Add New Message') }}" :links="$data" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.message-template.store') }}" method="POST" id="formTemplate">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="type" class="form-label">{{ __('Treatment') }}</label>
                                    <select name="treatment_id" id="treatment_id" class="form-control">
                                        <option value="">{{ __('Select Treatment') }}</option>
                                        @if(!is_null($treatments))
                                            @foreach($treatments as $treatment)
                                                <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="status" class="form-label">{{ __('Languages') }}</label>
                                    <select name="language_id" id="language_id" class="form-control">
                                        <option value="">{{ __('Select Language') }}</option>
                                        @if(!is_null($languages))
                                            @foreach($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="type" class="form-label">{{ __('Type') }}</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="whatsapp">{{ __('Whatsapp') }}</option>
                                        <option value="email">{{ __('Email') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="action" class="form-label">{{ __('Action') }}</label>
                                    <select name="action" id="action" class="form-control">
                                        <option value="medical_form">{{ __('Medical Form') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <h5 class="">{{ __('Content:') }}</h5>
                                <div class="editor" id="editor" style="min-height: 400px">

                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                    <div class="card-footer mt-3">
                        <p>
                            {!! __('Meta Keywords: :words', ['words' => \Illuminate\Support\Arr::join(["username", "password", "patient_name", "patient_surname", "your_medical_form_link"], ',')]) !!}
                        </p>
                        <br />
                        <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('themes/backend/default/assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('themes/backend/default/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('themes/backend/default/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/quill/quill.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            var quill = new Quill('#editor', {
                theme: 'snow'
            });

            $('#formTemplate').submit(function(){
                var content = quill.root.innerHTML;
                $('#formTemplate').append('<input type="hidden" name="content" value="'+content+'" />');
            });
        });
    </script>
@endpush
