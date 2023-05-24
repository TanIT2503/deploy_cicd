@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-md-4">
            <div class="card">
                <form id="createAccount" v-on:submit.prevent="add()">
                    <div class="card-header">
                        Thêm Mới Tài Khoản
                    </div>
                    <div class="card-body">
                        <label class="mt-1">Quyền</label>
                        <select name="id_quyen" class="form-control">
                            <option value="1">Admin</option>
                            <option value="2">Tài xế</option>
                        </select>
                        <label>Họ Và Tên</label>
                        <input name="ho_va_ten" class="form-control mt-1" type="text" placeholder="Nhập vào họ và tên">
                        <label>Email</label>
                        <input name="email" class="form-control mt-1" type="email" placeholder="Nhập vào email">
                        <label>Mật Khẩu</label>
                        <input name="password" class="form-control mt-1" type="text">
                        <label>Nhập Lại Mật Khẩu</label>
                        <input name="re_password" class="form-control mt-1" type="text">
                        <label>Số Điện Thoại</label>
                        <input name="so_dien_thoai" class="form-control mt-1" type="text"
                            placeholder="Nhập vào số điện thoại">
                        <label>Ngày Sinh</label>
                        <input name="ngay_sinh" class="form-control mt-1" type="date" placeholder="Nhập vào ngày sinh">
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Thêm Mới Tài Khoản</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Danh Sách Tài Khoản
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Quyền</th>
                                    <th class="text-center">Họ Và Tên</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Số Điện Thoại</th>
                                    <th class="text-center">Ngày Sinh</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(v, key) in listAdmin">
                                    <tr>
                                        <th class="text-center align-middle">@{{ key + 1 }}</th>
                                        <td class="align-middle text-nowrap">
                                            <template v-if="v.id_quyen == 1">
                                                <button v-on:click="status(v.id,v.id_quyen)"
                                                    class="btn btn-primary">Admin</button>
                                            </template>
                                            <template v-if="v.id_quyen == 2">
                                                <button v-on:click="status(v.id,v.id_quyen)" class="btn btn-warning">Tài
                                                    xế</button>
                                            </template>

                                        </td>
                                        <td class="align-middle">@{{ v.ho_va_ten }}</td>
                                        <td class="align-middle">@{{ v.email }}</td>
                                        <td class="align-middle">@{{ v.so_dien_thoai }}</td>
                                        <td class="align-middle">@{{ date_format(v.ngay_sinh) }}</td>
                                        <td class="text-center text-nowrap align-middle">
                                            {{-- <button class="btn btn-info">Cập Nhật</button> --}}
                                            <a v-on:click="getDetail(v)" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fa-regular fa-pen-to-square fa-xl " style="color: #2baebf;"></i>
                                                </i></a>
                                            <a v-on:click="delete_Admin = v" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"><i class="fa-solid fa-trash fa-xl"
                                                    style="color: #f00a2c;"></i></a>
                                            {{-- <button  button-icon name="trash-outline"></button> --}}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Model Delete --}}
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xóa Nhân Viên</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn muốn xóa nhân viên: <b>"@{{ delete_Admin.ho_va_ten }}"</b> này không?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="delete_admin()" type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">Xác Nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Model Edit --}}
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Chỉnh Sửa Nhân Viên</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="update_account">
                                    <input type="hidden" name="id" v-model="account_Admin.id">

                                    <div class="col-md-12 mb-2">
                                        <label>Họ Và Tên</label>
                                        <input v-model="account_Admin.ho_va_ten" name="ho_va_ten"
                                            class="form-control mt-1" type="text" placeholder="Nhập vào họ và tên">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Email</label>
                                        <input v-model="account_Admin.email" name="email" class="form-control mt-1"
                                            type="email" placeholder="Nhập vào email">
                                    </div>
                                    <select v-model="account_Admin.id_quyen" class="form-control">
                                        <option value="1">Admin</option>
                                        <option value="2">Tài xế</option>
                                    </select>

                                    <div class="col-md-12 mb-2">
                                        <label>Số Điện Thoại</label>
                                        <input v-model="account_Admin.so_dien_thoai" name="so_dien_thoai"
                                            class="form-control mt-1" type="text"
                                            placeholder="Nhập vào số điện thoại">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Ngày Sinh</label>
                                        <input v-model="account_Admin.ngay_sinh" name="ngay_sinh"
                                            class="form-control mt-1" type="date" placeholder="Nhập vào ngày sinh">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="update_Admin()" type="button" class="btn btn-primary"
                                    data-bs-dismiss="modal">Xác Nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                listAdmin: [],
                account_Admin: {},
                delete_Admin: {},
            },
            created() {
                this.loadData();
            },
            methods: {
                date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
                },
                add() {
                    var paramObj = {};
                    $.each($('#createAccount').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });

                    axios
                        .post('/admin/tai-khoan/create', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã thêm mới tài khoản!");
                                this.loadData();
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },

                loadData() {
                    axios
                        .get('/admin/tai-khoan/data')
                        .then((res) => {
                            this.listAdmin = res.data.data;
                        });
                },

                delete_admin() {
                    axios
                        .post('/admin/tai-khoan/delete', this.delete_Admin)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã xóa tài khoản thành công!");
                                this.loadData();
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },

                getDetail(value) {
                    this.account_Admin = Object.assign({}, value);
                },

                update_Admin() {
                    var paramObj = {};
                    $.each($('#update_account').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });

                    axios
                        .post('/admin/tai-khoan/update', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã cập nhập tài khoản!");
                                this.loadData();
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                status(id, id_quyen) {
                    var payload = {
                        'id': id,
                        'id_quyen': id_quyen,
                    };
                    axios
                        .post('/admin/tai-khoan/status', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                }
            },
        });
    </script>
@endsection
