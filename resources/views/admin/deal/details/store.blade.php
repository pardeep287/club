<div class="col-md-12">
    <h4>Store Details</h4>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name: </strong> {{ $deal->store->name}}</li>
        <li class="list-group-item"><strong>City: </strong> {{ $deal->store->city->name}}</li>
        <li class="list-group-item"><strong>Mobile: </strong> {{ $deal->store->mobile}}</li>
        <li class="list-group-item"><strong>Address: </strong>
            <br> {!! $deal->store->formatted_address() !!}</li>
    </ul>
</div>