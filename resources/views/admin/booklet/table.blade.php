<table class="table table-hover" id="booklet-list">
    <thead>
    <tr>
        @if(!isset($minified))
            <td>City</td>
        @endif
        <td>Image</td>
        <td>Booklet Name</td>
        <td>Price</td>
        @if(!isset($minified))
            <td>Validity</td>
            <td>Action</td>
        @endif

        @if(isset($customfunction))
            <td>Custom</td>
        @endif
    </tr>
    </thead>

    <tbody>
    @foreach($booklets as $booklet)
        <tr>
            @if(!isset($minified))
                <td>{{ $booklet->city->name }}</td>
            @endif
            <td>
                <img src="{{ asset($booklet->imageAvatar()) }}" alt="{{ $booklet->name }}" class="img img-responsive"
                     style="height: 72px;">
            </td>
            <td>{{ $booklet->name }}</td>
            <td>{{ $booklet->price }}</td>
            @if(!isset($minified))
                <td>{{ $booklet->validity }}</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="{{ route('booklet_deals', $booklet->id) }}">
                        <span class="fa fa-tag"></span> View Deals
                        ({{ str_pad($booklet->deals->count(), '3','0', STR_PAD_LEFT) }})
                    </a>
                    <a href="{{ route('code', $booklet->id )}}"
                       class="btn btn-sm {{ ($booklet->usable) ? 'btn-info' : 'btn-danger' }}">
                        <span class="fa fa-qrcode"></span> Codes ({{ $booklet->codesLeft() }}) left
                    </a>
                    @if(authority_match(\App\User::$admin))

                        @if(false)
                            <a class="btn btn-sm btn-danger" href="{{ route('booklet_delete', $booklet->id) }}"
                               onclick="event.preventDefault(); document.getElementById('booklet-{{ $booklet->id }}').submit();">
                                <span class="fa fa-trash"></span> Delete
                            </a>
                            <form id="booklet-{{ $booklet->id }}" action="{{ route('booklet_delete', $booklet->id) }}"
                                  method="POST" style="display: none;">
                                {{ csrf_field() }}{!! method_field('delete') !!}
                            </form>
                        @endif

                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#booklet-edit" data-id="{{ $booklet->id }}"
                                data-city="{{ $booklet->city_id }}"
                                data-name="{{ $booklet->name }}" data-price="{{ $booklet->price }}"
                                data-validity="{{ $booklet->validity }}">
                            <span class="fa fa-edit"></span> Edit Booklet
                        </button>
                    @endif
                </td>
            @endif

            @if(isset($customfunction))
                <td>
                    <button type="button" class="btn btn-sm btn-warning {{ $customfunction }} "
                            @foreach($functionprops as $prop) data-{{ $prop }}="{{ $booklet->$prop }}" @endforeach>
                        {{ ucwords(str_replace('_', ' ', $customfunction)) }}
                    </button>

                    <button class="btn btn-sm btn-success"
                            @foreach(array_keys($booklet->toArray()) as $key) data-{{ $key }}="{{ $booklet->$key }}" @endforeach >
                        NEW
                    </button>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
@if(authority_match(\App\User::$admin)) @include('admin.booklet.edit') @endif

@section('scripts')
    <script>
        var bookletlisttable = $("#booklet-list");
        $(initialiseDataTable(bookletlisttable));
    </script>
@append