@extends('admin.layouts.main')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-50 rounded">
                        </div>
                        <div class="text-right">
                            <i> Category: {{ $product->category->name }}</i>
                        </div>

                        <hr>

                        <h4>{{ $product->name }}</h4>
                        <p class="tmt-3">
                            {!! $product->description !!}
                        </p>
                        <div class="text-right">
                            <i> Price: {{ $product->price }}</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
