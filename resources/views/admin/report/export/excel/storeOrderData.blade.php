<table>
    <thead>
    <tr>
        <td>Order ID</td>
        <td>Deal ID</td>
        <td>Deal Title</td>
        <td>Client</td>
        <td>Mobile</td>
        <td>Status</td>
        <td>Redeem Mode</td>
        <td>CC Transaction</td>
        <td>Code</td>
        <td>Created At</td>
    </tr>
    </thead>

    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->deal->id }}</td>
            <td>{{ $order->deal->title }}</td>
            <td>{{ $order->client->name }}</td>
            <td>{{ $order->client->mobile }}</td>
            <td>{{ ucwords($order->status) }}</td>
            <td>{{ ucwords($order->redeem_mode) }}</td>
            <td>{{ $order->ccTransaction->tracking_id }}</td>
            <td>{{ $order->dealCoupon->code }}</td>
            <td>{{ $order->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>