@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Medical Forms'),
                'url' => route('admin.medical-forms.index')
            ],
            [
                'title' => __('Edit Medical Form'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Edit Medical Form') }}" :links="$data" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('admin.medical-forms.update', ['medical_form' => $form->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Medical Form Name') }}</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('Medical From Name') }}" value="{{ $form->title ?? old('title') }}">
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
                                        @php($selected = $form->language_id == $language->id ? 'selected' : '')
                                        <option value="{{ $language->id }}" {{ $selected }}>{{ $language->name }}</option>
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
                                        @php($selected = $form->treatment_id == $treatment->id ? 'selected' : '')
                                        <option value="{{ $treatment->id }}" {{ $selected }}>{{ $treatment->name }}</option>
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
                        <input type="text" name="description" id="description" class="form-control" placeholder="{{ __('Description') }}" value="{{ $form->description ?? old('description') }}">
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="settings" class="form-label">{{ __('Medical Form Settings') }}</label>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="form-check mb-2">
                                    @php( $isChecked = array_key_exists('calculateBMI', $form->settings) && ($form->settings['calculateBMI']  == 'yes') ? 'checked' : '' )
                                    <input type="checkbox" class="form-check-input" id="calculateBMI" name="settings[calculateBMI]" value="yes" {{ $isChecked }}>
                                    <label class="form-check-label" for="calculateBMI">Calculate BMI</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check mb-2">
                                    @php( $isChecked = array_key_exists('emergencyContactName', $form->settings) && ($form->settings['emergencyContactName']  == 'yes') ? 'checked' : '' )
                                    <input type="checkbox" class="form-check-input" id="emergencyContactName" name="settings[emergencyContactName]" value="yes" {{ $isChecked }}>
                                    <label class="form-check-label" for="emergencyContactName">Emergency Contact Name</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
