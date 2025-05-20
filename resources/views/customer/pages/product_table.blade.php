@foreach($products as $product)
    @php $sizes = explode(',', $product->category->sizes); @endphp
    <div class="col-lg-4 mb-4">
        <div class="item">
            <div class="thumb">
                <div class="hover-content">
                    <ul>
                        <li>
                            <a href="{{ route('customer.showProductDetail', $product->id) }}" class="action-button">
                                <i class="fa fa-eye"></i>
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('customer.addToCart') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="size" value="{{ $sizes[0] ?? 'M' }}">
                                <button type="submit" class="action-button">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <img src="{{ $product->image ?? '/customer/images/products/default.jpg' }}" alt="{{ $product->name }}">
            </div>
            <div class="down-content">
                <h4>{{ $product->name }}</h4>
                <span>{{ number_format($product->discount_price) }} VND</span>
            </div>
        </div>
    </div>
@endforeach
