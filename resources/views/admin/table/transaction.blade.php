@foreach($client->transactions as $transaction)
<tr>
    <td>{{ $transaction->deal->store->name }}</td>
    <td>{{ $transaction->deal->title }}</td>
    <td>{{ $transaction->created_at }}</td>
</tr>
@endforeach