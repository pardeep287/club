<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Type</th>
        <th>Referred By</th>
        <th>Lifetime Direct Referrals</th>
        <th>Lifetime Indirect Referrals</th>
        <th>City</th>
        <th>Created At</th>
        <th>Device ID</th>
        <th>Device Usage</th>
    </tr>
    </thead>

    <tbody>
    @foreach($clients as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->mobile }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->client_type }}</td>
            <td>{{ $client->referredBy->mobile }}</td>
            <td>{{ $client->referredTo->count() }}</td>
            <td>{{ $client->indirectReferral }}</td>
            <td>{{ $client->city->name }}</td>
            <td>{{ $client->created_at }}</td>
            <td>{{ $client->device_id }}</td>
            <td>{{ $client->install_kind }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
