@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-md-3">
            <div class="card">
                <form id="addlichtrinh" v-on:submit.prevent="add()">
                    <div class="card-header">
                        <b>
                            THÊM LỊCH TRÌNH
                        </b>
                    </div>
                    <div class="card-body">
                        <label class="mt-1">Tên Tuyến</label>
                        <select name="id_tuyen" id="" class="form-control">
                            <option value="">Mời bạn chọn tuyến</option>
                            <template v-for="(value, key) in list_tuyen">
                                <option v-bind:value="value.id">@{{value.ten_tuyen}}</option>
                            </template>
                        </select>
                        <label class="mt-1">Biển số xe</label>
                        <select name="id_xe" id="" class="form-control">
                            <option value="">Mời bạn chọn...</option>
                            <template v-for="(value, key) in list_xe">
                                <option v-bind:value="value.id">@{{value.bien_so_xe}}</option>
                            </template>
                        </select>
                        <label class="mt-1">Tài xế</label>
                        <select name="id_tai_xe" id="" class="form-control">
                            <option value="">Mời bạn chọn tài xế...</option>
                            <template v-for="(value, key) in list_tai_xe">
                                <option v-bind:value="value.id">@{{value.ho_va_ten}}</option>
                            </template>
                        </select>
                        <label class="mt-1">Thời lượng hiệu chỉnh</label>
                        <input type="text" class="form-control" name="thoi_luong_hieu_chinh" placeholder="Nhập vào phút">
                        <label class="mt-1">Thời lượng nghỉ</label>
                        <input type="text" class="form-control" name="thoi_luong_nghi" placeholder="Nhập vào phút">
                        <label class="mt-1">Ngày khởi chạy</label>
                        <input type="date" class="form-control" name="ngay_khoi_chay">
                        <label class="mt-1">Thời gian bắt đầu</label>
                        <input type="time" class="form-control" name="thoi_gian_bat_dau">
                        <label class="mt-1">Tình Trạng</label>
                        <select name="tinh_trang" class="form-control">
                            <option value="1">Đang Chạy</option>
                            <option value="2">Sắp Chạy</option>
                            <option value="0">Ngưng Chạy</option>
                        </select>

                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <b>
                        DANH SÁCH LỊCH TRÌNH
                    </b>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th class="align-middle text-nowrap">#</th>
                                    <th class="align-middle text-nowrap">Tuyến</th>
                                    <th class="align-middle text-nowrap">Ngày chạy</th>
                                    <th class="align-middle text-nowrap">Thời gian</th>
                                    <th class="align-middle text-nowrap">Thời lượng nghỉ</th>
                                    <th class="align-middle text-nowrap">Xe</th>
                                    <th class="align-middle text-nowrap">Tài xế</th>
                                    <th class="align-middle text-nowrap">Tình Trạng</th>
                                    <th class="align-middle text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(v, key) in listLichTrinh">
                                    <tr class="text-center">
                                        <td class="align-middle text-nowrap">@{{ key + 1 }}</td>
                                        <td class="align-middle text-nowrap">@{{ v.ten_tuyen}}</td>
                                        <td class="align-middle text-nowrap">@{{ v.ngay_khoi_chay }}</td>
                                        <td class="align-middle text-nowrap">@{{ thoigian(v.thoi_gian_bat_dau, v.thoi_luong_hieu_chinh) }}</td>
                                        <td class="align-middle text-nowrap">@{{ v.thoi_luong_nghi }}</td>
                                        <td class="align-middle text-nowrap">@{{ v.id_xe }}</td>
                                        <td class="align-middle text-nowrap">@{{ v.id_tai_xe }}</td>
                                        <td class="align-middle text-nowrap">
                                            <template v-if="v.tinh_trang == 1">
                                                <button v-on:click="change(v)" class="btn btn-primary">Đang Chạy</button>
                                            </template>
                                            <template v-if="v.tinh_trang == 2">
                                                <button v-on:click="change(v)" class="btn btn-warning">Sắp Chạy</button>
                                            </template>
                                            <template v-if="v.tinh_trang == 3">
                                                <button v-on:click="change(v)" class="btn btn-danger">Ngưng Chạy</button>
                                            </template>
                                        </td>
                                        <td>
                                            <a v-on:click="update_lichtrinh = v" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa-regular fa-pen-to-square fa-xl " style="color: #2baebf;"></i>
                                                </i></a>
                                            <a v-on:click="delete_lichtrinh = v" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"><i class="fa-solid fa-trash fa-xl"
                                                    style="color: #f00a2c;"></i></a>
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
                                Bạn có chắc chắn muốn xóa lịch trình: <b>"@{{ delete_lichtrinh.id_tuyen }} @{{ delete_lichtrinh.thoi_gian_bat_dau }}"</b>
                                này không?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="delete_LichTrinh()" type="button" class="btn btn-danger"
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
                                    <label>ID Tuyến</label>
                                    <input class="form-control" v-model="update_lichtrinh.id_tuyen" type="text">
                                    <label class="mt-1">Tên Tuyến</label>
                                    <input class="form-control" v-model="update_lichtrinh.ten_tuyen">
                                    <label class="mt-1">Xe</label>
                                    <input v-model="update_lichtrinh.id_xe" class="form-control" type="text">
                                    <label class="mt-1">Tài xế</label>
                                    <input type="text" class="form-control" v-model="update_lichtrinh.id_tai_xe">
                                    <label class="mt-1">Thời lượng hiệu chỉnh</label>
                                    <input type="text" class="form-control"
                                        v-model="update_lichtrinh.thoi_luong_hieu_chinh" placeholder="Nhập vào phút">
                                    <label class="mt-1">Thời lượng nghỉ</label>
                                    <input type="text" class="form-control" v-model="update_lichtrinh.thoi_luong_nghi"
                                        placeholder="Nhập vào phút">
                                    <label class="mt-1">Ngày khởi chạy</label>
                                    <input type="date" class="form-control" v-model="update_lichtrinh.ngay_khoi_chay">
                                    <label class="mt-1">Thời gian bắt đầu</label>
                                    <input type="time" class="form-control"
                                        v-model="update_lichtrinh.thoi_gian_bat_dau">

                                    <label class="mt-1">Tình Trạng</label>
                                    <select v-model="update_lichtrinh.tinh_trang" class="form-control">
                                        <option value="1">Đang Chạy</option>
                                        <option value="2">Sắp Chạy</option>
                                        <option value="0">Ngưng Chạy</option>
                                    </select>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="update_LichTrinh()" type="button" class="btn btn-primary"
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
                listLichTrinh: [],
                delete_lichtrinh: {},
                update_lichtrinh: {},
                listtime: [],
                list_tuyen : [],
                list_xe    : [],
                list_tai_xe: [],
                dem        : 1,
            },
            created() {
                this.loadData();
            },
            methods: {

                add() {
                    var paramObj = {};
                    $.each($('#addlichtrinh').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    console.log(paramObj);

                    axios
                        .post('/admin/lich-trinh/create', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã thêm mới lịch trình!");
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
                        .get('/admin/lich-trinh/data')
                        .then((res) => {
                            this.listLichTrinh = res.data.data;
                            this.list_tuyen    = res.data.tuyen;
                            this.list_xe       = res.data.xe;
                            this.list_tai_xe   = res.data.tai_xe;
                        });
                },

                thoigian(time, delay) {
                    this.listtime = time.split(':');
                    var gio = (delay - (delay % 60)) / 60;
                    var phut = delay % 60;

                    var array = [];

                    this.listtime.forEach(function(value, key) {
                        array[key] = parseInt(value);
                    });

                    array[0] += gio;
                    array[1] += phut;

                    if(array[1]>60){
                        array[0] += (array[1] - (array[1] % 60)) / 60;
                        array[1] = array[1]%60;
                    }

                    array = array.join(":");
                    return array;
                },

                delete_LichTrinh() {
                    axios
                        .post('/admin/lich-trinh/delete', this.delete_lichtrinh)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Lịch trình đã được xóa!!!");
                                this.loadData();
                            } else {
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

                update_LichTrinh() {
                    console.log(this.update_lichtrinh);
                    axios
                        .post('/admin/lich-trinh/update', this.update_lichtrinh)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Đã cập nhập tuyến xe!");
                                this.loadData();
                            } else {
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
                change(v){
                    var dem = this.dem;
                    if(dem < 3) {
                        this.dem = dem + 1;
                    } else {
                        this.dem = 1;
                    }

                    var payload = {
                        'id'         : v.id,
                        'tinh_trang' : v.tinh_trang,
                        'dem'        : this.dem,
                    };
                    axios
                        .post('/admin/lich-trinh/status', payload)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else {
                                toastr.error('Có lỗi không mong muốn!');
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
@endsection
