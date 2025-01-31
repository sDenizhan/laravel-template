@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Medical Forms'),
                'url' => ''
            ],
            [
                'title' => __('Show Medical Form'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Show Medical Form') }}" :links="$data" />
@endsection

@section('content')
    @dd($form)
@endsection
