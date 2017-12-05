<table class="table table-hover" id="users-table">
    <thead>
    <tr>
        <td>Avatar</td>
        <td>Name</td>
        <td>Mobile</td>
        <td>Email</td>
        @if(authority_match(\App\User::$admin))
            <td>Password</td>
            <td>Auth Level</td>
            <td>Edit</td>
        @endif
    </tr>
    </thead>

    <tbody>
    @foreach($users as $user)
        <tr>
            <td>
                <img src="{{ asset($user->imageAvatar()) }}" alt="{{ $user->name }}" class="img img-responsive"
                     style="height: 48px;">
            </td>
            <td>{{ ucwords($user->name) }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $user->email }}</td>
            @if(authority_match(\App\User::$admin))
                <td>{{ $user->password }}</td>
                <td>{{ ucwords($user->auth_level) }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#user-edit"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                            data-mobile="{{ $user->mobile }}" data-auth="{{ $user->auth_level }}">
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    <form action="{{ route('user.password.reset') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{ $user->id }}" name="id">
                        <button class="btn btn-sm btn-danger">
                            <i class="fa fa-unlock"></i> Reset Password
                        </button>
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>


@section('scripts')
    <script>
        var usersTable = $("#users-table");
        $(initialiseDataTable(usersTable));
    </script>
@append