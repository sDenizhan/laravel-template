@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Permissions'),
                'url' => route('admin.permissions.index')
            ],
            [
                'title' => __('Edit Permission'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Edit Permission') }}" :links="$data" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('admin.permissions.update', ['permission' => $permission->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ $permission->name }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="guard_name" class="form-label">{{ __('Guard') }}</label>
                        <input type="text" name="guard_name" id="guard_name" class="form-control" placeholder="{{ __('Guard') }}" value="{{ $permission->guard_name }}">
                        @error('guard_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection