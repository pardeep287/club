@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active"><span class="fa fa-flag"></span> Reports</li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(isset($client))
                    @include('admin.report.client_details')
                @elseif(isset($user))
                    @include('admin.report.user_details')
                @else
                    <h3>Reports</h3>
                @endif
            </div>

            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>TXN ID</td>
                            <td>Transacted On</td>
                            <td>Store</td>
                            <td>Deal</td>
                            <td>User</td>
                            <td>Mobile</td>
                            <td>Client</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>TXN #{{ str_pad($transaction->id, 10, '0', STR_PAD_LEFT)}}</td>
                            <td>{{ $transaction->created_at }}</td>
                            <td>
                                <a href="{{route('store_deals', $transaction->deal->store->id)}}">
                                    {{ $transaction->deal->store->name }}
                                </a>
                            </td>
                            <td>{{ $transaction->deal->title }}</td>
                            <td>
                                @if(authority_match(\App\User::$admin))
                                <a href="{{ route('user_trans', $transaction->user->id) }}">
                                    {{ $transaction->user->name }}
                                </a>
                                @else
                                    {{ $transaction->user->name }}
                                @endif

                            </td>

                            <td>{{ $transaction->client->mobile }}</td>
                            <td>
                                <a href="{{ route('client_trans',$transaction->client_id) }}">
                                    {{ ucwords($transaction->client->name) }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection