@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('deal') }}"><span class="fa fa-tag"></span> Deals</a></li>
            <li class="active"><span class="fa fa-tag"></span> Expired Deals</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-exclamation"></i> Expired Deals {{ App\Deal::expired()->count() }}
                </div>

                <div class="panel-body">
                    <form action="{{ route('deal.expired.handle') }}" method="post">
                        {!! csrf_field() !!}
                        <fieldset class="col-md-2">
                            <label class="col-md-1">
                                Days
                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       placeholder="Number of days to extend (from today)" name="days" required>
                            </div>
                        </fieldset>
                        <fieldset class="col-md-10" style="height: 70vh; overflow-y: scroll;">
                            <label for="deals">Expired Deals</label>
                            @foreach($deals as $deal)
                                <div class="row">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="deals[]"
                                                   value="{{ $deal->id }}">
                                            <img src="{{ $deal->thumbAvatar() }}" alt="{{ $deal->title }}" width="96px"
                                                 class="img img-thumbnail">
                                            <strong>{{ $deal->title }}</strong>,
                                            <span class="text-muted">{{ $deal->store->name }}</span>
                                            <span class="text-danger">
                                                    (expired on: {{ $deal->end->format('Y-m-d') }})
                                                </span>
                                            <a href="{{route('deal.view')}}?deal={{ $deal->id }}" target="_blank">
                                                View Deal &raquo;
                                            </a>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </fieldset>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                Extend
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection