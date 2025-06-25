@php use App\Models\Invoice; @endphp
@foreach($invoices as $key => $val)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $val->invoice_code ?? 'N/A' }}</td>
        <td>{{ $val->customer_name ?? 'N/A' }}</td>
        <td class="text-center">{{ $val->customer_phone ?? 'N/A' }}</td>
        <td class="text-center">{{ $val->status ? Invoice::STATUSES[$val->status] : 'N/A' }}</td>
        <td class="text-center">{{ $val->payment_status ? Invoice::PAYMENT_STATUSES[$val->payment_status] : 'N/A' }}</td>
        <td class="text-center">{{ $val->payment_method ? Invoice::PAYMENT_METHODS[$val->payment_method] : 'N/A' }}</td>
        <td class="text-center">{{ $val->total_amount ? number_format($val->total_amount) : 'N/A' }}</td>
        <td class="text-center">
            <button type="button" onclick="confirmDownload('{{ route('admin.invoice.exportInvoicePdf', $val->id) }}')"
                    class="btn btn-sm btn-warning">
                <i class="fas fa-file-pdf"></i>
            </button>
            <button
                class="btn btn-sm btn-info btn-view-product"
                data-bs-toggle="modal"
                data-bs-target="#invoiceModal{{ $val->id }}"
            >
                <i class="fas fa-eye"></i>
            </button>
            <a href="{{ route('admin.invoice.showUpdate', $val->id) }}"
               class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
            <button class="btn btn-sm btn-danger"
                    onclick="confirmDelete('{{ route('admin.invoice.delete', $val->id) }}')"
            >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
    @include('admin.pages.invoice.detail')
@endforeach
<script>
    function confirmDownload(url) {
        if (confirm('Bạn có chắc chắn muốn in hóa đơn này không?')) {
            window.open(url, '_blank');
        }
    }
</script>
