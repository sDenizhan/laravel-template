@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Medical Forms'),
                'url' => route('admin.medical-forms.index')
            ],
            [
                'title' => __('Add New'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Add New Medical Form') }}" :links="$data" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('admin.medical-forms.store') }}" method="POST" id="create">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Medical Form Name') }}</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Medical From Name') }}" value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="language_id" class="form-label">{{ __('Language') }}</label>
                                <select name="language_id" id="language_id" class="form-control">
                                    <option value="">{{ __('Select Language') }}</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="treatment_id" class="form-label">{{ __('Treatment') }}</label>
                                <select name="treatment_id" id="treatment_id" class="form-control">
                                    <option value="">{{ __('Select Treatment') }}</option>
                                    @foreach ($treatments as $treatment)
                                        <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                                    @endforeach
                                </select>
                                @error('treatment_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="{{ __('Description') }}" value="{{ old('description') }}">
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="settings" class="form-label">{{ __('Medical Form Settings') }}</label>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="calculateBMI" name="settings[calculateBMI]" value="yes">
                                    <label class="form-check-label" for="calculateBMI">Calculate BMI</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="emergencyContactName" name="settings[emergencyContactName]" value="yes">
                                    <label class="form-check-label" for="emergencyContactName">Emergency Contact Name</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row step_row">
                        <div class="col-lg-2">
                            <label for="steps" class="form-label">{{ __('Step Number') }}</label>
                            <input type="number" name="step_no[]" id="step_no" class="form-control" value="1" step="1" />
                        </div>

                        <div class="col-lg-8">
                            <label for="steps" class="form-label">{{ __('Step Title') }}</label>
                            <input type="text" id="step_title" name="step_title[]" class="form-control" value="" />
                        </div>

                        <div class="col-lg-2">
                            <button type="button" id="new" class="btn btn-primary mt-3 add"><i class="fas fa-plus"></i></button>
                            <button type="button" id="new" class="btn btn-secondary mt-3 remove"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-primary save">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){

            $(document).on('click', 'button.add', function (e){
                e.preventDefault();
                let clonedStep = $('.step_row:first').clone().addClass('step_cloned');
                clonedStep.find('input:first').val($('.step_row').length + 1);
                clonedStep.insertAfter('.step_row:last');
            });

            $(document).on('click', 'button.remove', function (e){
                e.preventDefault();
                if($('.step_cloned').length > 0){
                    $('.step_cloned:last').remove();
                }
            });

        });
    </script>
@endpush
