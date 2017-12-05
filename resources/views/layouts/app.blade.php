<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JB') }}</title>

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style2.css') }}" rel="stylesheet">
    <!-- web font -->
    <link href="{{ asset('/fonts/font-awesome.min.css') }}" rel="stylesheet">
    <!--<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/b-1.3.1/b-colvis-1.3.1/b-html5-1.3.1/b-print-1.3.1/cr-1.3.3/r-2.1.1/rg-1.0.0/sc-1.4.2/datatables.min.css"
    />


    <!-- Column Filterings -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/yadcf/0.9.1/jquery.dataTables.yadcf.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/yadcf/0.9.1/jquery.dataTables.yadcf.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.css"/>

    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->


    @yield('styles')
</head>

<body>
@include('layouts.navigation')

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> {{ session('message') }}

        </div>

    @endif @include('layouts.errors') @yield('content') @include('admin.user.password')
</div>
<!--/.main-->
<script src="{{ asset('/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<!-- <script src="{{ asset('/js/chart.min.js') }}"></script> -->
<!--<script src="{{ asset('/js/chart-data.js') }}"></script>-->
<!--<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>-->


<script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/b-1.3.1/b-colvis-1.3.1/b-html5-1.3.1/b-print-1.3.1/cr-1.3.3/r-2.1.1/rg-1.0.0/sc-1.4.2/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/yadcf/0.9.1/jquery.dataTables.yadcf.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/yadcf/0.9.1/jquery.dataTables.yadcf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.js"></script>

<script src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/js/ckeditor/adapters/jquery.js') }}"></script>
<script>
    String.prototype.capitalize = function () {
        return this.charAt(0).toUpperCase() + this.slice(1);
    };

    String.prototype.lpad = function (padString, length) {
        var str = this;
        while (str.length < length)
            str = padString + str;
        return str;
    };

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }

    var datePickerOptions;
    function initialiseDateRange(start, end) {
        start.datepicker(datePickerOptions);
        end.datepicker(datePickerOptions);
        start.on("change", function () {
            end.datepicker("option", "minDate", getDate(this));
        });
        end.on("change", function () {
            start.datepicker("option", "maxDate", getDate(this));
        });

    }

</script>
<script>
    var dataTable;
    var current = "";

    function initialiseDataTable(table) {
        dataTable = table; //.DataTable();
        if (dataTable.length != 0) {
            var mTable = dataTable.DataTable({
                colReorder: true,
                responsive: true,
                dom: 'Bfrtip',
                extend: 'collection',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'pageLength',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'columnsToggle'
                ],
                initComplete: function () {
                    if (typeof yadcf_conf != 'undefined') {
                        dataTable.dataTable().yadcf(yadcf_conf);
                        // yadcf.init(mTable, yadcf_conf);
                    }
                }
            });
            $(".dataTables_wrapper select, .dataTables_wrapper input").addClass("form-control");
        }
    }

</script>


@yield('scripts')

@stack('datatables')
</body>

</html>