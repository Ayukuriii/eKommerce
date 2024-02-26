@extends('adminlte::page')

@section('title', 'Order')

@section('content_header')
    <h1>Order</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <a href="{{ route('export.order') }}" class="btn btn-md btn-dark mb-3 mr-1">Export</a>
            <table class="table table-striped table-hover" id="serverside">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Created At</th>
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
                ajax: '{{ route('admin.orders.index') }}',
                columns: [{
                        name: 'id',
                        data: 'id'
                    },
                    {
                        name: 'name',
                        data: 'name'
                    },
                    {
                        name: 'status',
                        data: 'status'
                    },
                    {
                        name: 'payment_type',
                        data: 'payment_type'
                    },
                    {
                        name: 'gross_amount',
                        data: 'gross_amount'
                    },
                    {
                        name: 'date',
                        data: 'date',
                    },
                    {
                        name: 'action',
                        data: 'action',
                    }
                ]
            });
        });
    </script>
@stop
