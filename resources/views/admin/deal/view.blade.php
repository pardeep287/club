@extends('layouts.app')
@section('content')
    @include("admin.deal.details.holder", ['deal' => $deal])
@endsection
