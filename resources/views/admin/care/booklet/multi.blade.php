@extends('layouts.app') @section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h3 class="page-title">Customer Care Booklet Purchase</h3>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Get Booklet code</h5>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('givebooklets_submit') }}" class="form" method="post">
                            {{ csrf_field() }}
                            <fieldset class="col-md-4">
                                <label for="mobile" class="form-controllabel">Mobile Number</label>
                                <select class="form-control sales clients" name="mobile" required>
                                    @foreach(App\Client::where('client_type','sales')->orderBy('name')->get() as $executive)
                                        <option value="{{ $executive->mobile }}">
                                            {{ $executive->name }}, {{ $executive->mobile }}
                                            , {{ $executive->city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <fieldset class="col-md-2">
                                <label for="booklet" class="form-controllabel">Booklet Desired</label>
                                <select name="booklet" id="customer-booklet" class="form-control">
                                    @foreach(App\Booklet::all()->groupBy('city_id') as $city_id => $booklets)
                                        <optgroup label="{{ App\City::find($city_id)->name }}">
                                            @foreach($booklets as $booklet)
                                                <option value="{{ $booklet->id }}" {{ (old('booklet') === $booklet->id) ? 'selected' : '' }} > {{ $booklet->name }}
                                                    ({{ $booklet->codesLeft() }})
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </fieldset>

                            <fieldset class="col-md-2">
                                <label for="customer-transaction" class="form-controllabel">Transaction Notation</label>
                                <input type="text" class="form-control" value="{{ old('transaction') }}"
                                       name="transaction">
                            </fieldset>

                            <fieldset class="col-md-2">
                                <label for="customer-transaction" class="form-controllabel">Quantity</label>
                                <input type="number" class="form-control" value="{{ old('quantity') }}" name="quantity"
                                       min="0">
                            </fieldset>

                            <fieldset class="col-md-2">
                                <label for="customer-submit" class="form-controllabel"> Get Code</label>
                                <br>
                                <button class="btn btn-primary">
                                    <span class="fa fa-qrcode"></span> <strong>Go</strong> <span
                                            class="fa fa-qrcode"></span>
                                </button>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if(isset($bk))

        @if(isset($excelInfo))
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Codes</div>
                    <div class="panel-body">
                        @include('admin.report.export.excel.multibooklet',['booklets' => $bk, 'client' => $client])
                    </div>
                </div>
            </div>
        </div>

@section('scripts')
    <script>
        var multipleBookletCodes = $("#multiple-booklet-codes");
        $(initialiseDataTable(multipleBookletCodes));
    </script>
@append

@endif

@section('scripts')
    <script>
        $(function () {
            $("select[name='booklet']").chosen();
            $("select[name='mobile']").chosen();
        });
    </script>
@append

@endsection