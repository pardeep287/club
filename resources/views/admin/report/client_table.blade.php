<table class="table table-hover">
    <thead>
        <tr>
            <td>Client</td>
            <td>Mobile No</td>
            @if(!isset($minified))
            <td>Address</td>
            <td>Email</td>
            @endif
            <td class="active text-center">Transactions Made</td>
        </tr>
    </thead>

    <tbody>
        @foreach($clients as $client)
        <tr>
            <td>
                <a href="#">
                    {{ ucwords($client->name) }}
                </a>
            </td>
            <td>
                {{ $client->mobile }}
            </td>
            @if(!isset($minified))
            <td>
                {{ $client->address }}
            </td>
            <td>
                {{ $client->email }}
            </td>
            @endif
            <td class="active text-center" >{{ $client->transactions()->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>