@foreach($data as $key => $val)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $val->code ?? 'N/A' }}</td>
        <td class="text-center">
            <img src="{{ $val->image ?? '/images/default.jpg' }}" alt="" width="100px" height="100px">
        </td>
        <td>{{ $val->category_name ?? 'N/A' }}</td>
        <td>{{ $val->name ?? 'N/A' }}</td>
        <td class="text-center">{{ $val->quantity ?? 0 }}</td>
    </tr>
@endforeach
