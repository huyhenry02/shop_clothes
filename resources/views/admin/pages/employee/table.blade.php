@foreach($employees as $key => $val)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $val->full_name ?? 'N/A' }}</td>
        <td>{{ $val->user->phone ?? 'N/A' }}</td>
        <td>{{ $val->email ?? 'N/A' }}</td>
        <td>{{ $val->position ?? 'N/A' }}</td>
        <td>{{ $val->address ?? 'N/A' }}</td>
        <td class="text-center">
            <a href="{{ route('admin.employee.showUpdate', $val->id) }}"
               class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
            <button class="btn btn-sm btn-danger"
                    onclick="confirmDelete('{{ route('admin.employee.delete', $val->id) }}')"
            >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach
