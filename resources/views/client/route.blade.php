@extends('client.homepage')
@section('menu')
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">Car<span>Book</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
            @php
                $check = Auth::guard('khach_hang')->user();
                // dd($check);
            @endphp
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                    <li class="nav-item active"><a href="/client/route" class="nav-link">Route</a></li>

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
    <p class="breadcrumbs"><span class="mr-2"><a href="/">Home <i class="ion-ios-arrow-forward"></i></a></span>
        <span>Route <i class="ion-ios-arrow-forward"></i></span>
    </p>
    <h1 class="mb-3 bread">Route </h1>
@endsection
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-md-12 ftco-animate mb-5">
            <label for="">
                Tìm kiếm tuyến đường <i class="ion-ios-arrow-forward"></i>

            </label>
            <form id="search" v-on:submit.prevent="timkiem()">
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-3">
                        <input name="tu_dau" class="form-control" type="text" placeholder="Từ">
                    </div>
                    <div class="col-md-3">
                        <input name="den_dau" class="form-control" type="text" placeholder="Đến">
                    </div>
                    <div class="col-md-2 text-center">
                        <button class="btn btn-primary" style="height: 52px; width: 100%;">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <template v-if="search == 1">
            <template v-for="(v, key) in list_tuyen_search" class="ftco-animate">
                <div class="col-md-4">
                    <div class="car-wrap rounded">
                        <img v-bind:src="v.avatar" style="height: 220px; width: 350px;">
                        <div class="text">
                            <h2 class="mb-0"><a href="#">@{{ v.ten_tuyen }}</a></h2>
                            <div class="d-flex mb-3">
                                <span class="cat">Thời gian dự kiến</span>
                                <p class="price ml-auto">@{{ doiphut(v.thoi_luong) }}</p>
                            </div>
                            <p class="mb-0 d-block text-center">
                                <a href="#" class="btn btn-secondary" style="width: 100%;">Chi tiết</a>
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </template>
        <template v-if="search == 0">
            <template v-for="(v, key) in list_tuyen" class="ftco-animate">
                <div class="col-md-4 ">
                    <div class="car-wrap rounded">
                        <img v-bind:src="v.avatar" style="height: 220px; width: 350px;">
                        <div class="text">
                            <h2 class="mb-0"><a href="#">@{{ v.ten_tuyen }}</a></h2>
                            <div class="d-flex mb-3">
                                <span class="cat">Thời gian dự kiến</span>
                                <p class="price ml-auto">@{{ doiphut(v.thoi_luong) }}</p>
                            </div>
                            <p class="mb-0 d-block text-center">
                                <a v-bind:href="'/client/lich-trinh-tuyen/'+v.id" class="btn btn-secondary"
                                    style="width: 100%;">Chi tiết</a>
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </template>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                list_tuyen: [],
                list_tuyen_search: [],
                search: 0,
            },
            created() {
                this.loadData();
            },
            methods: {

                loadData() {
                    axios
                        .get('/client/route/data')
                        .then((res) => {
                            // this.listLichTrinh = res.data.data;
                            this.list_tuyen = res.data.tuyen;
                            // this.list_xe = res.data.xe;
                            // this.list_tai_xe = res.data.tai_xe;
                            // console.log(this.list_tuyen);
                        });
                },

                doiphut(phut) {
                    var gio = (phut - (phut % 60)) / 60;
                    var phut = phut % 60;

                    // this.listtime = time.split(':');
                    var thoi_gian = [gio, phut];
                    thoi_gian = thoi_gian.join("H ");
                    return thoi_gian + 'P';
                },
                timkiem() {
                    var paramObj = {};
                    $.each($('#search').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    axios
                        .post('/client/tim-tuyen-duong', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                this.list_tuyen_search = res.data.data;
                                this.search = res.data.search;
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
