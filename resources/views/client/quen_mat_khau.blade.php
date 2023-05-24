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
            <li class="nav-item active"><a  href="/"  class="nav-link">Home</a></li>
            <li class="nav-item"><a href="/client/route" class="nav-link">Route</a></li>

            <li class="nav-item"><a href="/client/contact" class="nav-link">Contact</a></li>
            @if ($check)
                <li class="nav-item"><a href="/logout" class="nav-link">Logout</a></li>
            @else
                <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
            @endif
        </ul>
        </div>
    </div>
</nav>

@endsection
@section('page')
    <p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Quên Mật Khẩu<i class="ion-ios-arrow-forward"></i></span></p>
@endsection
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            Đổi Mật Khẩu
                        </div>
                    </div>
                </div>
                <form action="/lost-password" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-2">
                            <label for="" class="mb-1">Email</label>
                            <input name="email" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Xác Nhận</button>
                    </div>
                </form>
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
            add      : {},
        },
        created()   {

        },
        methods :   {
            // XacNhan() {
            //     axios
            //         .post('/quen-mat-khau', this.add)
            //         .then((res)=>{
            //             if(res.data.status == 1) {
            //                 toastr.success(res.data.message);
            //                 window.location.href = '/login';
            //             } else if(res.data.status == 0){
            //                 toastr.error(res.data.message);
            //             } else if(res.data.status == 2) {
            //                 toastr.warning(res.data.message);
            //             }
            //         })
            //         .catch((err) =>{

            //         });
            // },
        },
    });
</script>
@endsection
