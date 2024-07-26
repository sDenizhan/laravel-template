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
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
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
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="type" class="form-label">{{ __('Type') }}</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="whatsapp">{{ __('Whatsapp') }}</option>
                                        <option value="email">{{ __('Email') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(!is_null($languages))
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <div class="tab-content pt-0">
                                        @foreach($languages as $language)
                                            <h5 @class(['mt-3' => !$loop->first])>{{ $language->name }}</h5>
                                            <div @class(['editor']) id="{{ $language->code }}" style="max-height: 400px">
                                                <p>Cillum ad ut irure tempor velit nostrud occaecat ullamco aliqua anim Lorem sint. Veniam sint duis incididunt
                                                    do esse magna mollit excepteur laborum qui. Id id reprehenderit sit est eu aliqua occaecat quis et velit
                                                    excepteur laborum mollit dolore eiusmod. Ipsum dolor in occaecat commodo et voluptate minim reprehenderit
                                                    mollit pariatur. Deserunt non laborum enim et cillum eu deserunt excepteur ea incididunt minim occaecat.</p>
                                            </div>
                                            <input type="hidden" name="content[{{ $language->code }}]" value="">
                                        @endforeach
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        @endif
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
    <link href="{{ asset('themes/backend/default/assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('themes/backend/default/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('themes/backend/default/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/quill/quill.min.js') }}"></script>
    <script>

        $(document).ready(function(){

            $(document).find('.editor').each(function (index){
                let id = $(this).attr('id');
                var quill = new Quill('#'+id, {
                    theme: 'snow'
                });
            });

            $(document).on('submit', 'form#formTemplate', function (e){
                e.preventDefault();

                $('.tab-content').find('div.editor').each(function(index){
                    let id = $(this).attr('id');
                    let content = $(this).find('.ql-editor').html();
                    $(this).find('input').val(content);
                });

                $(this)[0].submit();
            })
        });
    </script>
@endpush
