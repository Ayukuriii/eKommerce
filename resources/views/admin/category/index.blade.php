@extends('adminlte::page')

@section('title', 'Category')

@section('content_header')
    <h1>Category</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <a href="{{ route('category.create') }}" class="btn btn-md btn-success mb-3">ADD CATEGORY</a>
            <table class="table table-striped" id="serverside">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
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
                ajax: '{{ route('category.index') }}',
                columns: [{
                        name: 'id',
                        data: 'id'
                    },
                    {
                        name: 'name',
                        data: 'name'
                    },
                    {
                        name: 'slug',
                        data: 'slug'
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
