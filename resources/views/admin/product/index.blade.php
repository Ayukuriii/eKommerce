@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Product</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <a href="{{ route('product.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
            <table class="table table-striped table-hover" id="serverside">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">qty</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#serverside').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('product.index') }}',
                columns: [{
                        name: 'id',
                        data: 'id'
                    },
                    {
                        name: 'name',
                        data: 'name'
                    },
                    {
                        name: 'description',
                        data: 'description'
                    },
                    {
                        name: 'price',
                        data: 'price'
                    },
                    {
                        name: 'qty',
                        data: 'quantity'
                    },
                    {
                        name: 'action',
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@stop
