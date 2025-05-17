@php use App\Models\Customer; @endphp
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
                            placeholder="Tìm kiếm theo tên, email, số điện thoại, ..."
                            class="form-control search-input"
                            id="search-input"
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
                            <h6>Danh sách khách hàng</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="display table table-bordered table-hover" id="account-table"
                            >
                                <thead>
                                <tr>
                                    <th width="3%">STT</th>
                                    <th>Tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sinh</th>
                                    <th>Số đơn hàng</th>
                                    <th class="text-center" width="12%">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->full_name ?? 'N/A' }}</td>
                                        <td>{{ $val->user->phone ?? 'N/A' }}</td>
                                        <td>{{ $val->email ?? 'N/A' }}</td>
                                        <td>{{ $val->address ?? 'N/A' }}</td>
                                        <td>{{ $val->gender ?  Customer::GENDERS[$val->gender] : 'N/A' }}</td>
                                        <td>{{ $val->birthday ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $val->orders()->count() ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.customer.showUpdate', $val->id) }}"
                                               class="btn btn-sm btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ route('admin.customer.delete', $val->id) }}')"
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
                            {!! $customers->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(url) {
            if (confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')) {
                window.location.href = url;
            }
        }
    </script>
@endsection
