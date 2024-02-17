@extends('admin.layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Add New Category
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Name</label>
                                <div>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="slug" class="font-weight-bold">Slug</label>
                                <div>
                                    <input id="slug" type="text"
                                        class="form-control @error('slug') is-invalid @enderror" name="slug"
                                        value="{{ old('slug') }}" autocomplete="slug">

                                    @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-0 mt-3">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
