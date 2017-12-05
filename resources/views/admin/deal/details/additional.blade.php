<div class="col-md-12">
    Categories
    <ul class="list-group">
        @foreach($deal->categories as $category)
            <li class="list-group-item">{{$category->name}}</li>
        @endforeach
    </ul>
</div>

<div class="col-md-12">
    Sub Categories
    <ul class="list-group">
        @foreach($deal->sub_categories as $sub_category)
            <li class="list-group-item">{{$sub_category->name}}</li>
        @endforeach
    </ul>
</div>

<section class="col-md-12">
    <h4>Maximum use before deal expires: {{ $deal->max_quantity }}</h4>
    <h4>Maximum use in a single day: {{ $deal->max_daily_limit }}</h4>
</section>
