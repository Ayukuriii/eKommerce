@extends('adminlte::page')

@section('title', 'Category')

@section('content_header')
    <h1>Category</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <a href="{{ route('category.create') }}" class="btn btn-md btn-success mb-3 mr-1">ADD CATEGORY</a>
            <a href="{{ route('export.categories') }}" class="btn btn-md btn-dark mb-3 mr-1">Export</a>
            {{-- <a href="{{ route('export.categories') }}" class="btn btn-md btn-dark mb-3 mr-1">Import</a> --}}
            <!-- Button trigger modal -->
            <button type="button" data-toggle="modal" data-target="#importModal"
                class="btn btn-md btn-dark mb-3 mr-1">Import</button>
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

        {{-- Modal --}}
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <p>Pastikan data sudah cocok dengan template.</p>
                            <a href="{{ route('template.categories') }}" download="filename.pdf"
                                class="btn btn-primary">Download Template</a>
                        </div>

                        <form action="{{ route('import.categories') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="templateFile" class="form-label">Input Docs</label>
                                <input class="form-control" type="file" id="templateFile" name="templateFile">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}');
        @elseif (session()->has('failed'))
            toastr.error('{{ session('failed') }}');
        @endif
    </script>
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
