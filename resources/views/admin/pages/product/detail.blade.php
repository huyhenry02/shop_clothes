<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Chi tiết sản phẩm: <span class="badge bg-warning text-dark ms-2" id="modal-code" style="font-size: 16px;"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body pb-1">
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <img id="modal-image" src="" alt="image" class="shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                        <img id="modal-image_detail_1" src="" alt="image_detail_1" class="shadow-sm mt-1" style="width: 120px; height: 120px; object-fit: cover;">
                        <img id="modal-image_detail_2" src="" alt="image_detail_1" class="shadow-sm mt-1" style="width: 120px; height: 120px; object-fit: cover;">
                        <img id="modal-image_detail_3" src="" alt="image_detail_1" class="shadow-sm mt-1" style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <div class="col-md-9 text-left">
                        <div class="product-info-row">
                            <div class="product-info-col">
                                <span class="product-info-label">Tên sản phẩm:</span>
                                <span class="product-info-value" id="modal-name"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Loại sản phẩm:</span>
                                <span class="product-info-value" id="modal-category"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Trạng thái:</span>
                                <span class="product-info-value" id="modal-is_active"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Slug:</span>
                                <span class="product-info-value" id="modal-slug"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Giá:</span>
                                <span class="product-info-value" id="modal-price"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Giá khuyến mại:</span>
                                <span class="product-info-value" id="modal-discount_price"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Số lượng trong kho:</span>
                                <span class="product-info-value" id="modal-stock_quantity"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Màu:</span>
                                <span class="product-info-value" id="modal-color"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Chất liệu:</span>
                                <span class="product-info-value" id="modal-material"></span>
                            </div>
                            <div class="product-info-col">
                                <span class="product-info-label">Phong cách:</span>
                                <span class="product-info-value" id="modal-style"></span>
                            </div>

                            <div class="product-info-col">
                                <span class="product-info-label">Mô tả:</span>
                                <span class="product-info-value" id="modal-description"></span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer pt-2">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<style>
    .product-info-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -12px;
    }

    .product-info-col {
        width: 50%;
        padding: 6px 12px;
        font-size: 14px;
    }

    .product-info-label {
        font-weight: 500;
        color: #6c757d;
        min-width: 140px;
        display: inline-block;
    }

    .product-info-value {
        width: 100%;
        font-weight: 600;
        color: #212529;
        display: inline-block;
    }

    @media (max-width: 768px) {
        .product-info-col {
            width: 100%;
        }
    }
</style>
