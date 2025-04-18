@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Treatments'),
                'url' => route('admin.treatments.index')
            ],
            [
                'title' => __('Add New'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Treatments') }}" :links="$data" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.treatments.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name" class="col-md-2 col-form-label">{{ __('Treatment Name') }}</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="status" class="col-md-2 col-form-label">{{ __('Treatment Status') }}</label>
                                <div class="col-md-12">
                                    <select name="status" id="status2" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(\App\Enums\Status::toArray() as $key => $value)
                                            <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills navtab-bg nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#translations" data-bs-toggle="tab" aria-expanded="false" class="nav-link active" aria-selected="true" role="tab">
                                {{ __('Translations') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#messages1" data-bs-toggle="tab" aria-expanded="false" class="nav-link" aria-selected="false" role="tab" tabindex="-1">
                                {{ __('Instructions') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="translations" role="tabpanel">
                            @if (!empty($languages))
                                @foreach($languages as $language)
                                    <div class="row mt-3">
                                        <label for="name" class="col-md-2 col-form-label">{{ $language->name }}</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="treatment_name" name="name[{{ $language->code }}]" value="{{ old('name.'.$language->code) }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="tab-pane" id="messages1" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        @if (!empty($languages))
                                            @foreach($languages as $language)
                                                <a @class(['nav-link mb-1', 'active show' => $loop->first]) id="v-pills-{{ \Illuminate\Support\Str::slug($language->name) }}-tab"
                                                   data-bs-toggle="pill" href="#v-pills-{{ \Illuminate\Support\Str::slug($language->name) }}"
                                                   role="tab" aria-controls="v-pills-{{ \Illuminate\Support\Str::slug($language->name) }}" aria-selected="false" tabindex="-1">
                                                    {{ $language->name }}
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-sm-9">
                                    <div class="tab-content pt-0">
                                        @if(!empty($languages))
                                            @foreach($languages as $lang)
                                                <div @class(['tab-pane fade', 'active show' => $loop->first])
                                                     id="v-pills-{{ \Illuminate\Support\Str::slug($lang->name) }}" role="tabpanel" aria-labelledby="v-pills-{{ \Illuminate\Support\Str::slug($lang->name) }}-tab">

                                                    <div class="row mb-3">
                                                        <label for="name" class="col-md-2 col-form-label">{{ __('Instructions After OP') }}</label>
                                                        <div class="col-md-12">
                                                            <textarea class="form-control summernote @error('ins_before_op') is-invalid @enderror" id="ins_before_op" name="ins_before_op[{{ $lang->code }}]">{{ old('ins_before_op.'.$lang->code) }}</textarea>
                                                            @if ($errors->has('ins_before_op'))
                                                                <span class="text-danger">{{ $errors->first('ins_before_op') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="ins_after_op" class="col-md-2 col-form-label">{{ __('Instructions After OP') }}</label>
                                                        <div class="col-md-12">
                                                            <textarea class="form-control summernote @error('ins_after_op') is-invalid @enderror" id="ins_after_op" name="ins_after_op[{{ $lang->code }}]">{{ old('ins_after_op.'.$lang->code) }}</textarea>
                                                            @if ($errors->has('ins_after_op'))
                                                                <span class="text-danger">{{ $errors->first('ins_after_op') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div> <!-- end col-->
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div>
    </div>
@endsection

@push('styles')
    <!-- third party css end -->
    <link href="{{ asset('themes/backend/default/assets/libs/summernote/summernote.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/summernote/summernote.min.js') }}" defer></script>

    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    }
                }
            });
        });
    </script>

@endpush
