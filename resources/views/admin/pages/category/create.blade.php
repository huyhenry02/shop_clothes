@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.category.postCategory') }}" enctype="multipart/form-data">
                @csrf
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Thông tin danh mục</h5>
                                <div class="form-group">
                                    <label>Tên danh mục sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label>Size sản phẩm <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="sizeInput" placeholder="Nhập size và nhấn Enter">
                                    </div>
                                    <div id="sizeContainer" class="mt-2"></div>
                                    <input type="hidden" id="sizeValues" name="sizes">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5>Mô tả</h5>
                                <div class="form-group">
                                    <label>Mô tả chi tiết</label>
                                    <textarea class="form-control" name="description" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-action text-end mt-3">
                    <button type="button" class="btn btn-outline-secondary">Hủy</button>
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    <style>
        .size {
            display: inline-flex;
            align-items: center;
            background-color: #f1f1f1;
            color: #333;
            border-radius: 20px;
            padding: 5px 10px;
            margin: 5px;
            font-size: 14px;
            font-weight: 500;
        }
        .size span {
            margin-left: 10px;
            cursor: pointer;
            font-weight: bold;
            color: red;
        }

    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sizeInput = document.getElementById("sizeInput");
            const sizeContainer = document.getElementById("sizeContainer");
            const sizeValues = document.getElementById("sizeValues");
            let sizes = [];

            sizeInput.addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    const sizeText = sizeInput.value.trim();
                    if (sizeText !== "" && !sizes.includes(sizeText)) {
                        sizes.push(sizeText);
                        updateSizeDisplay();
                    }
                    sizeInput.value = "";
                }
            });

            function updateSizeDisplay() {
                sizeContainer.innerHTML = "";
                sizes.forEach((size, index) => {
                    let sizeElement = document.createElement("div");
                    sizeElement.className = "size";
                    sizeElement.innerHTML = `${size} <span onclick="removeSize(${index})">&times;</span>`;
                    sizeContainer.appendChild(sizeElement);
                });
                sizeValues.value = sizes.join(",");
            }

            window.removeSize = function(index) {
                sizes.splice(index, 1);
                updateSizeDisplay();
            };
        });
    </script>
@endsection
