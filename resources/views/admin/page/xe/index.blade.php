@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm Mới Xe</h4>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label for="" class="mb-1">Biển Số Xe</label>
                        <input v-model="add.bien_so_xe" type="text" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Tình Trạng</label>
                        <select v-model="add.tinh_trang" name="" id="" class="form-control">
                            <option value="1">Hiểm Thị</option>
                            <option value="0">Tạm Tắt</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Hàng Dọc</label>
                        <input v-model="add.hang_doc" type="text" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Hàng Ngang</label>
                        <input v-model="add.hang_ngang" type="text" class="form-control">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" v-on:click="ThemMoi()">Thêm Mới</button>
                </div>
            </div>

        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4>Danh Sách Các Xe</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center text-nowrap">#</th>
                                    <th class="text-center text-nowrap">Tên xe</th>
                                    <th class="text-center text-nowrap">Tình Trạng</th>
                                    <th class="text-center text-nowrap">Ghế Hàng Dọc</th>
                                    <th class="text-center text-nowrap">Ghế Hàng Ngang</th>
                                    <th class="text-center text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in list">
                                    <th class="align-middle text-center">@{{ key + 1 }}</th>
                                    <td class="align-middle">@{{ value.bien_so_xe }}</td>
                                    <td class="align-middle text-center text-nowrap">
                                        <button v-on:click="changeStatus(value.id)" class="btn btn-danger" v-if="value.tinh_trang == 0">Dừng Hoạt Động</button>
                                        <button v-on:click="changeStatus(value.id)" class="btn btn-primary" v-else>Đang Hoạt Động</button>
                                    </td>
                                    <td class="align-middle text-center">@{{ value.hang_doc }}</td>
                                    <td class="align-middle text-center">@{{ value.hang_ngang }}</td>
                                    <td class="align-middle text-center text-nowrap">
                                        <button v-on:click="loadGhe(value.id, value.hang_ngang, value.hang_doc)" class="ghe btn btn-primary " style="margin-right: 5px" data-bs-toggle="modal" data-bs-target="#gheModal">Xem Ghế</button>
                                        <button v-on:click="update_xe = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#editModal" style="margin-right: 5px" class="btn btn-info">Cập Nhật</button>
                                        <button v-on:click="delete_xe = value"  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa Xe</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xóa Xe</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Chúng ta sẽ xóa Xe, đồng nghĩa với việc Xóa tất cả Ghế của Xe đó.</p>
                                    <p><b>Lưu ý:</b> Việc này không thể hoàn tác, hãy cẩn thận!</p>
                                </div>
                                <div class="modal-footer" >
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="xoaXe()" type="button" class="btn btn-primary"
                                        data-bs-dismiss="modal">Chấp Nhận Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Xe</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="edit_id">
                                    <div class="form-group mt-1">
                                        <label>Tên Phòng</label>
                                        <input  v-model="update_xe.bien_so_xe" type="text" class="form-control"
                                            placeholder="Nhập vào tên phòng">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Tình Trạng</label>
                                        <select  v-model="update_xe.tinh_trang"  class="form-control">
                                            <option v-bind:value="1">Còn Kinh Doanh</option>
                                            <option v-bind:value="0">Dừng Kinh Doanh</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Số Ghế Hàng Dọc</label>
                                        <input v-model="update_xe.hang_doc" type="number" class="form-control" >
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Số Ghế Hàng Ngang</label>
                                        <input v-model="update_xe.hang_ngang" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="capNhatXe()" type="button" class="btn btn-primary"
                                        data-bs-dismiss="modal">Cập Nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="gheModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Danh Sách Các Ghế</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-white text-center" role="alert">
                                        <div class="row">
                                            <div class="col">
                                                <h3><b>Tài Xế</b></h3>
                                            </div>
                                            <div class="col">
                                                <h3>
                                                    Cửa Ra Vào
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered" id="table_ghe">
                                        <thead>

                                        </thead>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
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
        el      :   '#app',
        data    :   {
            add         : {'tinh_trang' : 1},
            list        : [],
            list_ghe    : [],
            update_xe   : {},
            delete_xe   : {},
        },
        created()   {
            this.LoadDataXe();
        },
        methods :   {
            ThemMoi() {
                axios
                    .post('/admin/xe/create', this.add)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success(res.data.message);
                            this.add = {'tinh_trang' : 1};
                            this.LoadDataXe();
                        } else {
                            toastr.error(res.data.message);
                        }
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },
            LoadDataXe() {
                axios
                    .get('/admin/xe/data-xe')
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },
            changeStatus(id) {
                axios
                    .get('/admin/xe/change-status/' + id)
                    .then((res) => {
                        this.LoadDataXe();
                        toastr.success(res.data.message);
                    });
            },
            loadGhe(id_xe, hang_ngang, hang_doc) {
                axios
                    .get('/admin/xe/data-ghe/' + id_xe)
                    .then((res) => {
                        var list_ghe = res.data.danh_sach_ghe;
                        var noi_dung   = '';
                        var x          = 0;
                        for(j = 0; j < hang_ngang; j++){
                            noi_dung += '<tr>';
                            for(i = 0; i < hang_doc; i++){
                                x = j * hang_doc + i;
                                if(list_ghe[x].tinh_trang) {
                                    noi_dung += '<th data-id="'+ list_ghe[x].id +'" class="change text-center aligin-middle" style="height: 70px; font-size: 30px; background-color: #DEF5E5">'+ list_ghe[x].ten_ghe +'</th>';
                                } else {
                                    noi_dung += '<th data-id="'+ list_ghe[x].id +'" class="change text-center aligin-middle" style="height: 70px; font-size: 30px; background-color: red">'+ list_ghe[x].ten_ghe +'</th>';
                                }
                            }
                            noi_dung += '</tr>';
                        }
                        $("#table_ghe thead").html(noi_dung);
                });
            },
            xoaXe() {
                console.log(this.delete_xe);
                axios
                    .post('/admin/xe/delete', this.delete_xe)
                    .then((res) => {
                        toastr.success('Đã xóa xe thành công!');
                        this.LoadDataXe();
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },
            capNhatXe() {
                axios
                    .post('/admin/xe/update' , this.update_xe)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success(res.data.messs);
                            this.LoadDataXe();
                        } else {
                            toastr.error('Có lỗi không mong muốn!');
                        }
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },

        },
    });
</script>
@endsection
