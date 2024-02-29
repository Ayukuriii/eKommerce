@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Product</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <table class="table table-striped table-hover" id="serverside">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Body</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#serverside').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('notifications.index') }}',
                columns: [{
                        name: '#',
                        data: '#'
                    },
                    {
                        name: 'title',
                        data: 'title'
                    },
                    {
                        name: 'category',
                        data: 'category'
                    },
                    {
                        name: 'body',
                        data: 'body'
                    },
                    {
                        name: 'status',
                        data: 'status'
                    },
                    {
                        name: 'action',
                        data: 'action'
                    },
                ]
            })
        })
    </script>
@stop
