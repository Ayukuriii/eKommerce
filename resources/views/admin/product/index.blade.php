@extends('admin.layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="card-body">
            <a href="{{ route('product.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td class="text-center">
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-dark"><i
                                        class="fa fa-eye"></i></a>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-pencil-alt"></i></a>

                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                    action="{{ route('product.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                            class="fa fa-trash"></i></button>
                                </form>
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

        {{-- {{ $categories->links() }} --}}
    </div>
@endsection
