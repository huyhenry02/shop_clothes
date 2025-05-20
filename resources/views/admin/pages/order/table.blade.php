@php use App\Models\Order; use Carbon\Carbon;@endphp
@foreach($orders as $key => $val)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $val->order_code ?? 'N/A' }}</td>
        <td>{{ $val->shipping_name ?? 'N/A' }}</td>
        <td class="text-center">{{ $val->shipping_phone ?? 'N/A' }}</td>
        <td class="text-center">{{ $val->status ? Order::STATUSES[$val->status] : 'N/A' }}</td>
        <td class="text-center">{{ $val->payment_status ? Order::PAYMENT_STATUSES[$val->payment_status] : 'N/A' }}</td>
        <td class="text-center">{{ $val->payment_method ? Order::PAYMENT_METHODS[$val->payment_method] : 'N/A' }}</td>
        <td class="text-center">{{ $val->total_amount ? number_format($val->total_amount) : 'N/A' }}</td>
        <td class="text-center">
            <button
                class="btn btn-sm btn-info btn-view-product"
                data-bs-toggle="modal"
                data-bs-target="#orderModal{{ $val->id }}"
            >
                <i class="fas fa-eye"></i>
            </button>
            <a href="{{ route('admin.order.showUpdate', $val->id) }}"
               class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
        </td>
    </tr>
    @include('admin.pages.order.detail')
@endforeach
