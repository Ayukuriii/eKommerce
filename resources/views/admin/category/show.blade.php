@extends('admin.layouts.main')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <h4>{{ $category->name }}</h4>
                        <div class="text-right">
                            <i> slug: {{ $category->slug }}</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
