@php use App\Models\Product; @endphp
@foreach($products as $key => $val)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $val->code ?? 'N/A' }}</td>
        <td class="text-center">
            <img src="{{ $val->image ?? 'N/A' }}" alt="" srcset="" width="100px"
                 height="100px">
        </td>
        <td>{{ $val->category?->name ?? 'N/A' }}</td>
        <td>{{ $val->name ?? 'N/A' }}</td>
        <td>{{ $val->price ? number_format($val->price) : 'N/A' }} VND</td>
        <td>{{ $val->discount_price ? number_format($val->discount_price) : 'N/A' }} VND
        </td>
        <td class="text-center">{{ $val->stock_quantity ?? 'N/A' }}</td>
        <td class="text-center">
            <button
                class="btn btn-sm btn-info btn-view-product"
                data-bs-toggle="modal"
                data-bs-target="#productDetailModal"
                data-image="{{ $val->image ?? '/customer/images/products/default.jpg' }}"
                data-code="{{ $val->code ?? '' }}"
                data-name="{{ $val->name ?? '' }}"
                data-category="{{ $val->category?->name ?? '' }}"
                data-slug="{{ $val->slug ?? '' }}"
                data-description="{{ $val->description ?? '' }}"
                data-price="{{ $val->price ? number_format($val->price) : '' }}"
                data-discount_price="{{ $val->discount_price ? number_format($val->discount_price) : '' }}"
                data-stock_quantity="{{ $val->stock_quantity ?? '' }}"
                data-image_detail_1="{{ $val->image_detail_1 ?? '/customer/images/products/default.jpg' }}"
                data-image_detail_2="{{ $val->image_detail_2 ?? '/customer/images/products/default.jpg' }}"
                data-image_detail_3="{{ $val->image_detail_3 ?? '/customer/images/products/default.jpg' }}"
                data-color="{{ $val->color ?? '' }}"
                data-material="{{ $val->material ?? '' }}"
                data-style="{{ $val->style ? Product::STYLES[$val->style] : '' }}"
                data-is_active="{{ $val->is_active ? Product::STATUSES[$val->is_active] : '' }}"
            >
                <i class="fas fa-eye"></i>
            </button>
            <a href="{{ route('admin.product.putProduct', $val->id) }}"
               class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
            <button class="btn btn-sm btn-danger"
                    onclick="confirmDelete('{{ route('admin.product.delete', $val->id) }}')"
            >
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach
