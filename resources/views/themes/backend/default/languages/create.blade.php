@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Languages'),
                'url' => route('admin.languages.index')
            ],
            [
                'title' => __('Add New'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Add New Language') }}" :links="$data" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('admin.languages.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Short Code') }}</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="{{ __('Short Code') }}" value="{{ old('code') }}">
                                @error('code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="sort" class="form-label">{{ __('Sort') }}</label>
                                <input type="number" name="sort" id="sort" class="form-control" placeholder="{{ __('Sort') }}" value="{{ old('sort') }}">
                                @error('sort')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
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
</div>
@endsection
