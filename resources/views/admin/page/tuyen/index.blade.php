@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-md-3">
            <div class="card">
                <form id="createTuyen" v-on:submit.prevent="add()">
                    <div class="card-header">
                        Thêm Mới Tuyến Xe
                    </div>
                    <div class="card-body">
                        <label class="mt-2">Tên Tuyến</label>
                        <input name="ten_tuyen" class="form-control mt-1" type="text" placeholder="Nhập vào họ và tên">
                        <label class="mt-2">Điểm Đón Khách</label>
                        <input name="diem_don_khach" class="form-control mt-1" type="text">
                        <label class="mt-2">Điểm Trả Khách</label>
                        <input name="diem_tra_khach" class="form-control mt-1" type="text">
                        <label class="mt-2">Thời Lượng</label>
                        <input type="number" class="form-control mt-1" name="thoi_luong" placeholder="Nhập vào phút">
                        <label  class="mt-2">Ngày Khởi Chạy</label>
                        <input type="date" class="form-control mt-1" name="ngay_khoi_chay">
                        <div class="form-group">
                            <label class="mt-2">Avatar</label>
                            <div class="input-group mt-1">
                                <input name="avatar" id="avatar" class="form-control" type="text" name="filepath">
                                <span class="input-group-prepend">
                                    <a id="lfm" data-input="avatar" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                            </div>
                            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                        </div>
                        <div class="form-group">
                            <label>Mô Tả Ngắn</label>
                            <textarea name="mo_ta"  id="mo_ta" class="form-control mt-1" cols="30" rows="3"></textarea>
                        </div>

                        <label class="mt-2">Tình Trạng</label>
                        <select name="tinh_trang" class="form-control mt-1">
                            <option value="1">Đang Chạy</option>
                            <option value="2">Sắp Chạy</option>
                            <option value="0">Ngưng Chạy</option>
                        </select>
                        <div class="form-group">
                            <label class="mt-2">Giá Vé</label>
                            <input name="gia_ve" class="form-control mt-1" cols="30" rows="3">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button  class="btn btn-primary">Thêm Mới Tuyến</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Danh Sách Tuyến
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center text-nowrap align-middle">#</th>
                                    <th class="text-center text-nowrap align-middle">Tên Tuyến</th>
                                    <th class="text-center text-nowrap align-middle">Điểm Đón Khách</th>
                                    <th class="text-center text-nowrap align-middle">Điểm Trả Khách</th>
                                    <th class="text-center text-nowrap align-middle">Thời Lượng</th>
                                    <th class="text-center text-nowrap align-middle">Ngày Khởi Chạy</th>
                                    <th class="text-center text-nowrap align-middle">Avatar</th>
                                    <th class="text-center text-nowrap align-middle">Mô Tả</th>
                                    <th class="text-center text-nowrap align-middle">Giá Vé</th>
                                    <th class="text-center text-nowrap align-middle">Tình Trạng</th>
                                    <th class="text-center text-nowrap align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(v, key) in listTuyen">
                                    <tr>
                                        <th class="text-center align-middle text-nowrap">@{{ key + 1 }}</th>
                                        <td class="align-middle text-nowrap">@{{ v.ten_tuyen }}</td>
                                        <td class="align-middle text-nowrap">@{{ v.diem_don_khach }}</td>
                                        <td class="align-middle text-nowrap">@{{ v.diem_tra_khach }}</td>
                                        <td class="align-middle text-nowrap">@{{ v.thoi_luong }}</td>
                                        <td class="align-middle text-nowrap">@{{ date_format(v.ngay_khoi_chay)}}</td>
                                        <td class="align-middle text-nowrap">
                                            <img v-bind:src="v.avatar" class="img-fluid" style="max-width: 100px;">
                                        </td>
                                        <td class="align-middle text-nowrap">@{{ v.mo_ta}}</td>
                                        <td class="align-middle text-nowrap">@{{ format_number(v.gia_ve)}}</td>
                                        <td class="align-middle text-nowrap">
                                            <template v-if='v.tinh_trang == 1'>
                                                <button class="btn btn-primary text-nowrap" v-on:click="status(v.id,v.tinh_trang)">Đang Chạy</button>
                                            </template>
                                            <template v-if='v.tinh_trang == 0'>
                                                <button class="btn btn-danger text-nowrap" v-on:click="status(v.id,v.tinh_trang)">Ngưng Chạy</button>
                                            </template>
                                            <template v-if='v.tinh_trang == 2'>
                                                <button class="btn btn-warning text-nowrap" v-on:click="status(v.id,v.tinh_trang)">Sắp Chạy</button>
                                            </template>
                                        </td>

                                        <td class="text-center text-nowrap align-middle">
                                            {{-- <button class="btn btn-info">Cập Nhật</button> --}}
                                            <a v-on:click="showUpdate(v)" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fa-regular fa-pen-to-square fa-xl " style="color: #2baebf;"></i>
                                                </i></a>
                                            <a v-on:click="delete_tuyen = v" data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                                    class="fa-solid fa-trash fa-xl" style="color: #f00a2c;"></i></a>
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
                                <h5 class="modal-title" id="exampleModalLabel">Xóa tuyến xe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn muốn xóa tuyến xe: <b>"@{{ delete_tuyen.ten_tuyen }}"</b> này không?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="delete_Tuyen()" type="button" class="btn btn-danger"
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
                                <h5 class="modal-title" id="exampleModalLabel">Chỉnh Sửa Tuyến Xe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="update">
                                    <input type="hidden" name="id" v-model="update_tuyen.id">
                                    <div class="form-group">
                                        <label class="mt-1">Tên Tuyến Xe</label>
                                        <input v-model="update_tuyen.ten_tuyen"  class="form-control mt-1" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-1">Điểm Đón Khách</label>
                                        <input v-model="update_tuyen.diem_don_khach"  class="form-control mt-1" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-1">Điểm Trả Khách</label>
                                        <input v-model="update_tuyen.diem_tra_khach"  class="form-control mt-1" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-1">Thời Lượng</label>
                                        <input v-model="update_tuyen.thoi_luong"  class="form-control mt-1" type="text">
                                    </div>
                                    <div class="form-group">
                                    <label class="mt-1">Ngày Khởi Chạy</label>
                                    <input v-model="update_tuyen.ngay_khoi_chay" type="date" class="form-control mt-1" >
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-1">Avatar</label>
                                        <div class="input-group mt-1">
                                            <input name="avatar" id="avatar" class="form-control" type="text" name="filepath">
                                            <span class="input-group-prepend">
                                                <a id="lfm_update" data-input="avatar_update" data-preview="holder_update" class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                        </div>
                                        <div id="holder_update" style="margin-top:15px;max-height:100px;"></div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="mt-1">Mô Tả</label>
                                        <textarea v-model="update_tuyen.mo_ta" class="form-control mt-1" cols="30" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="mt-1">Tình Trạng</label>
                                        <select  v-model="update_tuyen.tinh_trang" class="form-control mt-1">
                                            <option value="1">Đang Chạy</option>
                                            <option value="2">Sắp Chạy</option>
                                            <option value="0">Ngưng Chạy</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>Giá Vé</label>
                                        <input v-model="update_tuyen.gia_ve" class="form-control mt-1" cols="30" rows="3">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="update_Tuyen()" type="button" class="btn btn-primary"
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
                listTuyen    : [],
                delete_tuyen : {},
                update_tuyen : {},
            },
            created() {
                this.loadData();
            },
            methods: {
                date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
                },
                format_number(number) {
                    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
                },
                add() {
                    var paramObj = {};
                    $.each($('#createTuyen').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    console.log(paramObj);

                    axios
                        .post('/admin/tuyen/create', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã thêm mới tuyến xe!");
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
                        .get('/admin/tuyen/data')
                        .then((res) => {
                            this.listTuyen = res.data.data;
                        });
                },

                delete_Tuyen() {
                    axios
                        .post('/admin/tuyen/delete', this.delete_tuyen)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã xóa tuyến xe thành công!");
                                this.loadData();
                            }
                            else {
                            if (res.data.message) {
                                toastr.error(res.data.message);
                            } else {
                                toastr.error('Có lỗi không mong muốn!');
                            }
                        }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                showUpdate(v) {
                    this.update_tuyen = v;
                    $("#avatar_update").val(v.avatar);
                    var text = '<img src="'+ v.avatar + '" style="margin-top:15px;max-height:100px;">'
                    $("#holder_update").html(text);
                },

                update_Tuyen() {
                    this.update_tuyen.avatar= $("#avatar_update").val();

                    axios
                        .post('/admin/tuyen/update', this.update_tuyen)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã cập nhập tuyến xe!");
                                this.loadData();
                            }
                         else {
                            if (res.data.message) {
                                toastr.error(res.data.message);
                            } else {
                                toastr.error('Có lỗi không mong muốn!');
                            }
                         }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },

                status(id,tinh_trang) {
                    var payload = {
                        'id'         : id,
                        'tinh_trang' : tinh_trang,
                    };
                    axios
                        .post('/admin/tuyen/status', payload)
                        .then((res) => {
                            if(res.data.status) {
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.19.1/ckeditor.js"></script>
<script>
    var route_prefix = "/laravel-filemanager";
</script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $("#lfm").filemanager('image', {prefix : route_prefix});
    $("#lfm_update").filemanager('image', {prefix : route_prefix});
</script>
@endsection
