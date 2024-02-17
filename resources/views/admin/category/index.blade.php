@extends('admin.layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <a href="{{ route('category.create') }}" class="btn btn-md btn-success mb-3">ADD CATEGORY</a>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td class="text-center">
                                <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-dark"><i
                                        class="fa fa-eye"></i></a>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-pencil-alt"></i></a>

                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                    action="{{ route('category.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4" class="alert alert-danger">
                                Data Kategori Belum Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $categories->links() }}
    </div>
@endsection
