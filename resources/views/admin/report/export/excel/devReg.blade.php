<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Client</th>
        <th>Mobile</th>
        <th>City</th>
        <th>Referred By</th>
        <th>Device ID</th>
        <th>Emulator</th>
        <th>Created At</th>
        <th>Additional JSON</th>
    </tr>
    </thead>

    <tbody>
    @foreach($regs as $reg)
        <tr>
            <td>{{ $reg->id }}</td>

            @if(!is_null($reg->client))
                <td>{{ $reg->client->name }}</td>
                <td>{{ $reg->client->mobile }}</td>
                <td>{{ $reg->client->city->name }}</td>
                <td>{{ $reg->client->referredBy->mobile }}</td>
            @else
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            @endif

            <td>{{ $reg->device_id }}</td>
            <td>{{ ($reg->emulator) ? "EMULATOR" : "-" }}</td>
            <td>{{ $reg->created_at }}</td>
            <td>{{ $reg->getOriginal('additional') }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
