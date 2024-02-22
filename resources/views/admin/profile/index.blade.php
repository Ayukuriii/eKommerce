@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-lime card-outline box-profile p-2 ">
                <div class="card-body">
                    <div class="text-center">
                        <img class="rounded-circle embed-responsive" src="{{ asset('assets/images/auth/user-default.png') }}"
                            alt="user-profile-default" srcset="">

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>
                        <p class="text-muted text-center">Admin</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">{{ $user->username }}</li>
                            <li class="list-group-item">{{ $user->email }}</li>
                            <li class="list-group-item">{{ $user->phone_number }}</li>
                        </ul>

                        <a href="{{ route('auth.profile.edit') }}" type="btn" class="btn btn-warning text-white">Edit
                            Profile</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card card-lime card-outline box-profile p-2 ">
                <div class="card-body">
                    <h3>Description</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore maxime, soluta recusandae laborum
                        vel commodi cum numquam, error consectetur, maiores magnam minus? Temporibus obcaecati accusantium
                        hic velit corporis dolorem iste, vitae sequi quasi odit voluptatem atque autem assumenda porro error
                        veritatis! Illum tenetur laudantium mollitia nisi optio voluptates molestiae animi, ex esse nulla
                        hic pariatur corrupti quos quaerat doloremque voluptatem ut ratione nam id ullam accusantium? Modi
                        itaque delectus molestias sequi, dolor excepturi dolores earum magnam quod? Ut, culpa. Totam
                        aspernatur, eligendi maiores at voluptatum, iure ad accusamus, harum impedit blanditiis cupiditate
                        enim ex tempore provident quae quo mollitia sequi eius nostrum. Illo, vitae, in architecto ad
                        corrupti similique iusto illum mollitia consequatur tempore delectus magni nemo autem atque quia aut
                        reprehenderit reiciendis perferendis culpa, earum laboriosam aspernatur! In odit eos quas enim!
                        Ipsam consequatur, sint quidem neque quam at, deserunt officiis porro unde delectus asperiores illo
                        assumenda sapiente. Unde!</p>

                    <h3>History</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias beatae neque facere repellat!
                        Expedita asperiores placeat ipsum recusandae et nihil id iste, dicta odit facere laborum laboriosam
                        magni animi dolore perspiciatis. Magni, quibusdam. Deleniti, odio expedita. Vitae esse error, dolore
                        quisquam temporibus id tempora accusantium illo laborum laboriosam excepturi consequatur.
                        Perspiciatis atque quibusdam earum, aliquam quia ipsum incidunt labore. Possimus commodi animi
                        veritatis suscipit, ut rem omnis! Deleniti non debitis sit esse doloremque nisi ab optio enim
                        praesentium? Corrupti cupiditate excepturi, facere tempora eligendi veniam assumenda at molestiae
                        nihil autem suscipit quo obcaecati voluptatibus numquam sequi nisi nesciunt perferendis. Quae
                        eveniet exercitationem deserunt dicta mollitia, obcaecati cupiditate eum magni dolorum, est cum
                        aperiam unde earum quod officia? Deserunt corrupti corporis perspiciatis sequi nemo, hic eaque
                        tenetur, illo fuga tempore molestias libero animi quam nihil fugiat fugit consectetur. Deleniti quam
                        temporibus odit asperiores veritatis et molestiae molestias? Veritatis quas aut explicabo ab alias
                        amet hic quaerat dolore possimus. Beatae suscipit assumenda nihil error ad quidem ratione molestias
                        velit sint ipsa unde cupiditate deserunt eius architecto ullam, odit officiis rerum pariatur
                        blanditiis quia quis autem? Minus, eligendi. Nisi explicabo iusto soluta id, numquam pariatur
                        eligendi. Temporibus excepturi obcaecati delectus accusamus aperiam blanditiis!</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @if (session('success'))
        <script>
            $(document).Toasts('create', {
                autohide: true,
                delay: 4000,
                class: 'bg-success',
                title: 'Success',
                body: '{{ session('success') }}'
            })
        </script>
    @endif
@stop
