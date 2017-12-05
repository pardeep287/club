<table class="table table-stripped">
    <thead>
    <tr>
        @foreach($columns as $key)
            <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
        @endforeach

        @if( isset($special_columns) && !empty($special_columns))
            @foreach($special_columns as $key => $values)
                @foreach($values as $value)
                    <td>{{ ucwords(str_replace('_', ' ', $key)) }} {{ ucwords(str_replace('_', ' ', $value)) }}</td>
                @endforeach
            @endforeach
        @endif
        @if(isset($buttons))
            @foreach(array_keys($buttons) as $button)
                <td>{{ ucwords(str_replace('_', ' ', $button)) }}</td>
            @endforeach
        @endif
    </tr>
    </thead>

    <tbody>
    @foreach($rows as $row)
        <tr>
            @foreach($columns as $column)
                <td>{{ $row->$column }}</td>
            @endforeach

            @if( isset($special_columns) && !empty($special_columns))
                @foreach($special_columns as $object => $values)
                    @if(!is_null($row->$object))
                        @foreach($values as $value)
                            <td>{{$row->$object->$value}}</td>
                        @endforeach
                    @else
                        <td>-</td>
                    @endif
                @endforeach
            @endif

            @if(isset($buttons))
                @foreach($buttons as $button => $values)
                    <td>
                        <button
                                @if(array_key_exists('onclick', $values)) onclick="{{ $values['onclick'] }}" @endif
                        class="btn btn-sm btn-{{ $values['class'] }}"
                                @if(isset($values['data']))
                                @foreach($values['data'] as $key => $value)
                                data-{{$key}}="{{ $value }}"
                                @endforeach
                                @endif
                                @foreach(array_keys($row->toArray()) as $key)
                                data-{{ $key }}="{{ $row->$key }}"
                                @endforeach
                        >
                            @if(array_key_exists('text', $values))
                                {{$values['text']}}
                            @else
                                {{ ucwords(str_replace('_', ' ', $button)) }}
                            @endif
                        </button>
                    </td>
                @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>

</table>