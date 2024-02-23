@extends('adminlte::page')

@section('title', 'Order')

@section('content_header')
    <h1>Order</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <table class="table table-striped table-hover" id="serverside">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price @</th>
                        <th scope="col">quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp.{{ number_format($item->product->price, 2, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5" class="alert alert-danger">
                                Data Kategori Belum Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
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
            $('#serverside').DataTable();
        });
    </script>
@stop
