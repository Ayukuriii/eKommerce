@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>User</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <table class="table table-striped table-hover" id="serverside">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Role</th>
                        <th scope="col">Join Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-dark"><i
                                        class="fa fa-eye"></i></a>
                            </td>
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

        {{ $users->links() }}
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
