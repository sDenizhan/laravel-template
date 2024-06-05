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
    <x-backend.breadcrumbs title="{{ __('Add New Permission') }}" :links="$data" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('admin.medical-forms.store') }}" method="POST">
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
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
