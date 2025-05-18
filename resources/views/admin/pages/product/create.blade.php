@php use App\Models\Product; @endphp
@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.product.postProduct') }}" enctype="multipart/form-data">
                @csrf
                <div class="card h-100">
                    <div class="card-body">
                        <h5>Thông tin sản phẩm</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tên sản phẩm<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Giá bán<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Giá giảm</label>
                                    <input type="number" class="form-control" name="discount_price">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Số lượng tồn kho<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="stock_quantity" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Chất liệu</label>
                                    <input type="text" class="form-control" name="material">
                                </div>
                                <div class="form-group form-check mt-3">
                                    <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
                                    <label class="form-check-label">Hiển thị sản phẩm</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Danh mục sản phẩm<span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Slug URL<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="slug" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Màu sắc</label>
                                    <input type="text" class="form-control" name="color">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Kiểu dáng</label>
                                    <select name="style" class="form-control">
                                        <option value="">-- Chọn kiểu --</option>
                                        @foreach(Product::STYLES as $key => $style)
                                            <option value="{{ $key }}">{{ $style }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Mô tả</label>
                                    <textarea name="description" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <h5>Ảnh sản phẩm</h5>
                            @php
                                $images = [
                                    'image' => 'Ảnh chính',
                                    'image_detail_1' => 'Ảnh chi tiết 1',
                                    'image_detail_2' => 'Ảnh chi tiết 2',
                                    'image_detail_3' => 'Ảnh chi tiết 3',
                                ];
                            @endphp
                            @foreach($images as $field => $label)
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ $label }}</label>
                                        <input type="file" class="form-control image-preview-input" name="{{ $field }}"
                                               accept="image/*">
                                        <img class="mt-2 img-thumbnail image-preview"
                                             style="width: 100%; max-height: 180px;" alt="" src="">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-action text-end mt-3">
                    <a href="{{ route('admin.product.showIndex') }}" class="btn btn-outline-secondary">Hủy</a>
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.image-preview-input').forEach(function (input) {
            input.addEventListener('change', function (e) {
                const preview = e.target.closest('.form-group').querySelector('.image-preview');
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
