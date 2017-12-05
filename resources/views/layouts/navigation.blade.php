<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"
               href="{{ route('dashboard') }}"><span><b>{{ explode(" ",config('app.name', 'J'))[0] }}</b></span> {{ substr(config('app.name' , 'J B'), strpos(config('app.name',"J B"), " ")) }}
            </a>
            <ul class="user-menu navbar-right">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>&nbsp;
                        {{ ucfirst(auth()->user()->name) }}, {{ auth()->user()->mobile }}
                        ||
                        <strong>
                            [{{ ucwords(auth()->user()->auth_level) }}]
                        </strong>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="#">
                                Authentication Level:
                                <strong>{{ ucwords(auth()->user()->auth_level) }}</strong>
                            </a>
                        </li>
                        <li>
                            <a href="/changepassword" data-toggle="modal" data-target="#edit-lk">
                                <span class="fa fa-key"></span> Change Password
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <span class="fa fa-lock"></span>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
    <!-- /.container-fluid -->
</nav>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form action="{{ route('client.avail.deal') }}" role="search">
        <div class="form-group mobile-search">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-mobile"></i>
                </div>
                <input class="form-control" name="mobile" type="text" placeholder="Mobile Search"
                       @if(isset($client)) value="{{ $client->mobile }}" @endif>
            </div>
        </div>
    </form>
    @component('layouts.nav.sidebar')
    @endcomponent
</div>
<!--/.sidebar-->