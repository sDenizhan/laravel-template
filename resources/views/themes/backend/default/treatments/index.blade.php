@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Treatments'),
                'url' => route('admin.treatments.index')
            ],
            [
                'title' => __('Index'),
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
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.treatments.create') }}">{{ __('Add New') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($treatments as $treatment)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $treatment->name }}</td>
                                <td>{{ \App\Enums\Status::from($treatment->status)->name }}</td>
                                <td>
                                    <form action="{{ route('admin.treatments.destroy', $treatment->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        @if ($treatment->name!='Super Admin')
                                            @can('edit-treatment')
                                                <a href="{{ route('admin.treatments.edit', $treatment->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                            @endcan

                                            @can('delete-treatment')
                                                @if ($treatment->name!=Auth::user()->hasRole($treatment->name))
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this treatment?');"><i class="bi bi-trash"></i> Delete</button>
                                                @endif
                                            @endcan
                                        @endif

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="3">
                            <span class="text-danger">
                                <strong>No Treatment Found!</strong>
                            </span>
                            </td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
