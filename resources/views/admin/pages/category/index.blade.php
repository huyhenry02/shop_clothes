@extends('admin.layouts.main')
@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Tìm kiếm:</label>
                        <input
                            type="text"
                            placeholder="Tìm kiếm theo tên"
                            class="form-control filter-input"
                            id="keywords"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h6>Danh sách danh mục</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="display table table-bordered table-hover"
                            >
                                <thead>
                                <tr>
                                    <th width="3%">STT</th>
                                    <th>Mã</th>
                                    <th>Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th>SIZE</th>
                                    <th class="text-center" width="12%">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody id="category-list">
                                    @foreach( $categories as $key => $category)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $category->code ?? 'N/A' }}</td>
                                            <td>{{ $category->name ?? 'N/A' }}</td>
                                            <td>{{ $category->description ?? 'N/A' }}</td>
                                            <td>{{ $category->sizes ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.category.showUpdate', $category->id) }}"
                                                   class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete('{{ route('admin.category.delete', $category->id) }}')"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {!! $categories->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(url) {
            if (confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này không?')) {
                window.location.href = url;
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#keywords').on('keyup', function () {
                let keyword = $(this).val();
                $.ajax({
                    url: '{{ route("admin.category.filter") }}',
                    method: 'GET',
                    data: { keyword: keyword },
                    success: function (res) {
                        $('#category-list').html(res.html);
                    }
                });
            });
        });
    </script>
@endsection
