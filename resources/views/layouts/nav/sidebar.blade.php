<ul class="nav menu">
    @if(Auth::user())
        @foreach (config('nav.admin.sidebar') as $parentKey => $parentMenu)

            @if((authority_match($parentMenu['level'])))
                <li class="{{ (current_route_equals($parentMenu['route'])) ? 'active' : '' }} {{ $parentFlag = array_key_exists( "child" , $parentMenu) ? 'parent' : null }}">
                    <a href="{{ route($parentMenu['route']) }}">
                        <span class="fa fa-{{ $parentMenu['icon'] }}"></span>
                        {{ $parentMenu['title'] }}

                        @if(!is_null($parentFlag))
                            <span data-toggle="collapse" href="{{ '#sub-item-'. $parentKey }}"
                                  class="icon pull-right text-right"><em
                                        class="glyphicon glyphicon-s glyphicon-plus"></em></span>
                        @endif
                    </a>

                    @if(isset($parentMenu['child']) && is_array($parentMenu['child']))
                        <ul class="children collapse" id="sub-item-{{ $parentKey }}">
                            @foreach ($parentMenu['child'] as $childKey => $childMenu)
                                @if((authority_match($childMenu['level'])))

                                    @if(( current_route_equals($parentMenu['route']) || current_route_equals($childMenu['route'])) ? 'in' : '')
                            @section('scripts')
                                <script>
                                    $('#sub-item-{{ $parentKey }}').parent().addClass('active');
                                    $('#sub-item-{{ $parentKey }}').addClass('in');
                                </script>
                            @append
                            @endif

                            <li class="{{ (current_route_equals($childMenu['route'])) ? 'active' : '' }}  ">
                                <a href="{{ route($childMenu['route']) }}">
                                    <span class="fa fa-{{ $childMenu['icon'] }}"></span>
                                    {{ $childMenu['title'] }}

                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif

        @endforeach
    @endif

    {{ $slot }}
</ul>