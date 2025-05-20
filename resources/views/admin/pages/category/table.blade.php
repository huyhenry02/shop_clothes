@foreach($categories as $key => $category)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $category->code ?? 'N/A' }}</td>
        <td>{{ $category->name ?? 'N/A' }}</td>
        <td>{{ $category->description ?? 'N/A' }}</td>
        <td>{{ $category->sizes ?? 'N/A' }}</td>
        <td class="text-center">
            <a href="{{ route('admin.category.showUpdate', $category->id) }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
            <button class="btn btn-sm btn-danger"
                    onclick="confirmDelete('{{ route('admin.category.delete', $category->id) }}')">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach
