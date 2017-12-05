<table>
    <thead>
    <tr>
        <th>Order Id</th>
        <th>Client</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>City</th>
        <th>Amount</th>
        <th>Tracking</th>
        <th>Status</th>
        <th>Order Type</th>
        <th>Order Title</th>
        <th>Store</th>
        <th>Code</th>
        <th>Remarks</th>
        <th>Additional</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    </thead>

    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>

            @if(!is_null($transaction->client))
                <td>{{ $transaction->client->name }}</td>
                <td>{{ $transaction->client->mobile }}</td>
                <td>{{ $transaction->client->email }}</td>
                <td>{{ $transaction->client->city->name }}</td>
            @else
                <td>-</td>
                <td>-</td>
                <td>-</td>
            @endif

            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->tracking_id }}</td>
            <td>{{ $transaction->status }}</td>
            <td>{{ $transaction->order_type }}</td>

            @if(!is_null($transaction->report))
                <td>{{ $transaction->report['details']['title']}}</td>
                <td>{{ $transaction->report['details']['store']}}</td>
                <td>{{ $transaction->report['code']}}</td>
                <td>{{ $transaction->report['remarks']}}</td>
                <td>{{ $transaction->report['additional']}}</td>
            @else
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            @endif

            <td>{{ $transaction->created_at }}</td>
            <td>{{ $transaction->updated_at }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
