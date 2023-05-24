@extends('client.homepage')
@section('menu')
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/">Car<span>Book</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
        </button>
        @php
            $check = Auth::guard('khach_hang')->user();
            // dd($check);
        @endphp
        <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a  href="/"  class="nav-link">Home</a></li>
            <li class="nav-item"><a href="/client/route" class="nav-link">Route</a></li>

            <li class="nav-item"><a href="/client/contact" class="nav-link">Contact</a></li>
            @if ($check)
                <li class="nav-item"><a href="/logout" class="nav-link">Logout</a></li>
            @else
                <li class="nav-item active"><a href="/login" class="nav-link">Login</a></li>
            @endif
        </ul>
        </div>
    </div>
</nav>

@endsection
@section('page')
    <p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Login<i class="ion-ios-arrow-forward"></i></span></p>
@endsection
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-3"></div>
        <div class="col-6" v-if='doi_page == 1'>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            Login Tài Khoản
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-danger" v-on:click="DoiPage()">Đăng Ký</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label for="" class="mb-1">Email</label>
                        <input v-model="login.email" type="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Passwork</label>
                        <input v-model="login.password" type="password" class="form-control">
                    </div>
                </div>
                <div class="card-footer ">
                    <div class="row">
                        <div class="col-4">
                            <a href="/lost-password" >Quên Mật Khẩu</a>
                        </div>
                        <div class="col-8 text-right">
                            <button class="btn btn-primary" v-on:click="Login()" >Đăng Nhập</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6" v-if='doi_page == 0'>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            Đăng Ký Tài Khoản
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-primary" v-on:click="DoiPage()">Login</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label for="" class="mb-1">Họ Đệm</label>
                        <input v-model="add.ho_lot" type="text" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Tên</label>
                        <input v-model="add.ten" type="text" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Email</label>
                        <input v-model="add.email" type="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Passwork</label>
                        <input v-model="add.password" type="password" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Số Điện Thoại</label>
                        <input v-model="add.so_dien_thoai" type="text" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="" class="mb-1">Giới tính</label>
                        <select v-model="add.gioi_tinh" class="form-control" name="" id="">
                            <option value="1">Nữ</option>
                            <option value="0">Nam</option>
                            <option value="3">Giới Tính Khác</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" v-on:click="DangKy()" >Đăng Ký</button>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
@endsection
@section('js')
<script>
    new Vue({
        el      :   '#app',
        data    :   {
            doi_page : 1,
            login    : {},
            add      : {},
        },
        created()   {

        },
        methods :   {
            Login() {
                axios
                    .post('/login', this.login)
                    .then((res)=>{
                        if(res.data.status == 1) {
                            toastr.success(res.data.message);
                            window.location.href = '/';
                        } else if(res.data.status == 0){
                            toastr.error(res.data.message);
                        } else if(res.data.status == 2) {
                            toastr.warning(res.data.message);
                        }
                    })
                    .catch((err) =>{
                        $.each(err.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        })
                    });
            },
            DangKy() {
                axios
                    .post('/dang-ky', this.add)
                    .then((res) => {
                        if(res.data.status) {
                            this.add = {};
                            toastr.success(res.data.message);
                            this.doi_page = 1;
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
            DoiPage() {
                this.doi_page = !this.doi_page;
            }
        },
    });
</script>
@endsection
