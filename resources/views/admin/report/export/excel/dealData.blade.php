<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Begin</th>
        <th>End</th>
        <th>Master Password</th>
        <th>Total Orders</th>
        <th>Successful Orders</th>
        <th>Coupons Left</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deals as $deal)
        <tr>
            <td>{{ $deal->id }}</td>
            <td>{{ $deal->title }}</td>
            <td>{{ $deal->begin }}</td>
            <td>{{ $deal->end }}</td>
            <td>{{ $deal->master_pass }}</td>
            <td>{{ $deal->orders->count() }}</td>
            <td>{{ $deal->orders()->where('status', 'success')->count() }}</td>
            <td>{{ $deal->couponsLeft }}</td>
        </tr>
    @endforeach
    </tbody>
</table>