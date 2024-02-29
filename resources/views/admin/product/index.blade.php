@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Product</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <a href="{{ route('product.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
            <a href="{{ route('export.product') }}" class="btn btn-md btn-dark mb-3 mr-1">Export</a>
            <!-- Button trigger modal -->
            <button type="button" data-toggle="modal" data-target="#importModal"
                class="btn btn-md btn-dark mb-3 mr-1">Import</button>

            <table class="table table-striped table-hover" id="serverside">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">qty</th>
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
                            <a href="{{ route('template.product') }}" download="filename.pdf"
                                class="btn btn-primary">Download Template</a>
                        </div>

                        <form action="{{ route('import.product') }}" method="post" enctype="multipart/form-data">
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
                        name: 'category',
                        data: 'category'
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
