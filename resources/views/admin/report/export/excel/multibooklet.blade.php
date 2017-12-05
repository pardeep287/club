<table class="table table-stripped" id="multiple-booklet-codes">
    <thead>
    <tr>
        <td>Index</td>
        <td>Executive</td>
        <td>Executive Mobile</td>
        <td>Code</td>
        <td>Begin</td>
        <td>End</td>
    </tr>
    </thead>

    <tbody>
    @foreach($booklets as $booklet)
        @if(isset($booklet['code']))
            <tr>
                <td>{{ $booklet['col_index'] }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->mobile }}</td>
                <td>{{ $booklet['code']->code }}</td>
                <td>{{ $booklet['code']->begin }}</td>
                <td>{{ $booklet['code']->end }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>