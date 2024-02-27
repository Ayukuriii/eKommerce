@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Product</h1>
@stop

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <div class="text-center">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-50 rounded">
                            @else
                                <img src="{{ asset('assets/images/product/No_image_available.svg.png') }}"
                                    class="w-50 rounded">
                            @endif
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
@stop
