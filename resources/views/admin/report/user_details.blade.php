<div>
    <div class="row">
        <div class="col-md-10">
            <h3>{{ $user->name }}</h3>
            <small>
                <ul>
                    <li>
                        <strong>Email:</strong> {{ $user->email }}
                    </li>
                    <li>
                        <strong>Auth Level:</strong> {{ $user->auth_level }}
                    </li>
                </ul>
            </small>
        </div>
    </div>
</div>