@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('booklet') }}"><span class="fa fa-book"></span> Booklets</a></li>
            <li class="active"><span class="fa fa-tag"></span> Deals</li>
        </ol>
    </div>
    <!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ "{$booklet->name}, {$booklet->city->name}" }}</h1>
            <h2>
                Already has {{ $booklet->deals()->count() }} deals.
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 panel panel-primary">
            <div class="panel-header">
                <h2>Stores</h2>
            </div>

            <div class="panel-body">
                @if(authority_match(\App\User::$admin))
                    <ul class="pagination">
                        @foreach($booklet->deals()->pluck('deals.title','deals.id') as $id => $title)
                            <li class="">
                                <a title="{{ $title }}" href="#da-{{$id}}">#{{$id}} &nbsp;</a>
                            </li>
                        @endforeach
                    </ul>

                    @include('admin.booklet.associationForm')
                @else
                    @foreach($booklet->deals as $deal)
                        @include('admin.deal.details.main', ['deal' =>$deal])
                    @endforeach
                @endif

            </div>

        </div>

    </div>

@endsection