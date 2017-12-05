@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>
                    {{ $client->name }}'s Booklets
                </h2>
            </div>
            <div class="panel-body">
                @include('admin.booklet.table')
            </div>

        </div>
    </div>
</div>

@endsection