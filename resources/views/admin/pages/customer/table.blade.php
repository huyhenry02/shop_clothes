@php use App\Models\Customer; @endphp
@foreach($customers as $key => $val)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $val->full_name ?? 'N/A' }}</td>
        <td>{{ $val->user->phone ?? 'N/A' }}</td>
        <td>{{ $val->email ?? 'N/A' }}</td>
        <td>{{ $val->address ?? 'N/A' }}</td>
        <td>{{ $val->gender ?  Customer::GENDERS[$val->gender] : 'N/A' }}</td>
        <td>{{ $val->birthday ?? 'N/A' }}</td>
        <td class="text-center">{{ $val->orders()->count() ?? 'N/A' }}</td>
        <td class="text-center">
            <a href="{{ route('admin.customer.showUpdate', $val->id) }}"
               class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
            <button class="btn btn-sm btn-danger"
                    onclick="confirmDelete('{{ route('admin.customer.delete', $val->id) }}')"
            >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach
