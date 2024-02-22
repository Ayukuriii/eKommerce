@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <div class="col-md-8">
        <div class="card card-lime card-outline box-profile p-2 ">
            <div class="card-body">
                <form method="POST" action="{{ route('auth.profile.update') }}">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <div>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $user->name) }}" autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Username --}}
                    <div class="form-group">
                        <label for="username" class="font-weight-bold">Username</label>
                        <div>
                            <input id="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username', $user->username) }}" autocomplete="username">

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email', $user->email) }}" autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="form-group">
                        <label for="phone_number" class="font-weight-bold">Phone Number</label>
                        <div>
                            <input id="phone_number" type="text"
                                class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                value="{{ old('phone_number', $user->phone_number) }}" autocomplete="phone_number">

                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="font-weight-bold">Password</label>
                        <div>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password">

                            @error('password')
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
@stop

@section('js')
    @if (session('failed'))
        <script>
            $(document).Toasts('create', {
                autohide: true,
                delay: 4000,
                class: 'bg-danger',
                title: 'Error',
                body: '{{ session('failed') }}'
            })
        </script>
    @endif
@stop
