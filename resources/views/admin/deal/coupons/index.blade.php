@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('deal') }}"><span class="fa fa-tags"></span> Deals</a></li>

            <li class="active"><span class="fa fa-tag"></span> Deals</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Codes</h1>
                            <h3>{{ $deal->title }}</h3>
                        </div>
                        <div class="col-md-12">
                            <form action="{{ route('deal_coupons_create') }}" method="POST"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="deal" value="{{ $deal->id }}">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="mechanism">Mechanism</label>
                                        <select class="form-control" name="mechanism" onchange="mechanismChange(this)">
                                            <option value="generate">Generate Coupons</option>
                                            <option value="import">Import Coupons</option>
                                        </select>
                                    </div>
                                    @section('scripts')
                                        <script>
                                            function mechanismChange(element) {
                                                var source = $(element);
                                                if (source.val() === 'generate') {
                                                    $('#importFields').addClass('hidden');
                                                    $('#generateFields').removeClass('hidden');
                                                } else {
                                                    $('#generateFields').addClass('hidden');
                                                    $('#importFields').removeClass('hidden');
                                                }
                                            }
                                        </script>
                                    @append
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input class="form-control" type="number" name="quantity"
                                               value="{{ (null !== old('quantity')) ? old('quantity') : 10 }}">
                                    </div>
                                </div>

                                <div class="col-md-5 hidden" id="importFields">
                                    <div class="form-group">
                                        <label for="excel">Excel Sheet</label>
                                        <input type="file" class="form-control" name="excel"
                                               accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div>
                                </div>

                                <div class="col-md-5" id="generateFields">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="method">Method of Generation</label>
                                            <select class="form-control" name="method">
                                                <option value="random">Random</option>
                                                <option value="simple">Simple</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="length">Length</label>
                                            <input class="form-control" type="number" name="length"
                                                   value="{{ (null !== old('length')) ? old('length') : 4 }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="value">Prefix/Value</label>
                                            <input class="form-control" type="text" name="value"
                                                   value="{{ (null !== old('value')) ? old('value') : strtoupper(substr($deal->store->name, 0, 5)) }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="validity">Validity</label>
                                        <input class="form-control" type="number" name="validity"
                                               value="{{ (null !== old('validity')) ? old('validity') : 30 }}">
                                    </div>
                                </div>

                                <div class="col-md-3 pull-right">
                                    <div class="form-group">
                                        <label for="submit">Create more coupons</label>
                                        <button class="btn btn-primary btn-block">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Handle Expired Codes</h3>
                            <h4 class="text-warning text-capitalize">Total ({{ $deal->coupons()->expired()->count() }})
                                codes which will not be sent to users</h4>

                            <form action="{{ route("deal.endangered.handle") }}" class="col-md-12" method="post">
                                {!! csrf_field() !!}
                                <div class="col-md-4">
                                    <select name="handle" id="handler" class="form-control">
                                        <option value="pause">Pause the Coupons</option>
                                        <option value="extend">Extend the expiry</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="days" placeholder="Number of days starting today"
                                           class="form-control">

                                    <input type="hidden" name="deal_id" value="{{ $deal->id }}">
                                </div>

                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label><input type="checkbox" checked name="include-paused">Include Paused
                                            Coupons</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <input type="submit" value="Handle" class="btn btn-info btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.deal.coupons.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection