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

            <li class="nav-item active"><a href="/client/contact" class="nav-link">Contact</a></li>
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
    <p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="ion-ios-arrow-forward"></i></a></span>
        <span>Contact <i class="ion-ios-arrow-forward"></i></span>
    </p>
    <h1 class="mb-3 bread">Contact Us</h1>
@endsection
@section('noi_dung')
    <div class="row d-flex mb-5 contact-info" id="app">
        <div class="col-md-4">
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="border w-100 p-4 rounded mb-2 d-flex">
                        <div class="icon mr-3">
                            <span class="icon-map-o"></span>
                        </div>
                        <p><span>Địa Chỉ: </span> 198 West 21th Street, Suite 721 New York NY 10016 <br> => Để là đâu bây giờ nhỉ? >.< </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="border w-100 p-4 rounded mb-2 d-flex">
                        <div class="icon mr-3">
                            <span class="icon-mobile-phone"></span>
                        </div>
                        <p><span>Phone: </span> <a href="tel://1234567920">Ngân: 0905 984 432</a></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="border w-100 p-4 rounded mb-2 d-flex">
                        <div class="icon mr-3">
                            <span class="icon-envelope-o"></span>
                        </div>
                        <p><span>Email:</span> <a href="mailto:info@yoursite.com">KimNgan969@gmail.com</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 block-9 mb-md-5">
            <form id="sendmail" v-on:submit.prevent="sendMail()" class="bg-light p-5 contact-form">
                <div class="form-group">
                    <input name="ho_va_ten" type="text" class="form-control" placeholder="Tên người gửi">
                </div>
                <div class="form-group">
                    <input name="email" type="text" class="form-control" placeholder="Nhập Email của bạn">
                </div>
                <div class="form-group">
                    <input name="tieu_de" type="text" class="form-control" placeholder="Tiêu đề">
                </div>
                <div class="form-group">
                    <textarea name="noi_dung" cols="30" rows="7" class="form-control" placeholder="Nội dung"></textarea>
                </div>
                <button class="btn btn-primary btn-lg" type="submit">Gửi Mail</button>
            </form>

        </div>
    </div>


    {{-- map --}}
    {{-- <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="map" class="bg-white"></div>
        </div>
    </div> --}}
@endsection
@section('js')
<script>
    new Vue({
        el: '#app',
        data: {
            listLichTrinh: [],
            delete_lichtrinh: {},
        },
        created() {
            // this.loadData();
        },
        methods: {

            sendMail() {
                var paramObj = {};
                $.each($('#sendmail').serializeArray(), function(_, kv) {
                    if (paramObj.hasOwnProperty(kv.name)) {
                        paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                        paramObj[kv.name].push(kv.value);
                    } else {
                        paramObj[kv.name] = kv.value;
                    }
                });
                console.log(paramObj);

                axios
                    .post('/client/contact', paramObj)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success("Đã thêm mới lịch trình!");
                            // this.loadData();
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
