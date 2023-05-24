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
            <li class="nav-item  active"><a href="/client/route" class="nav-link">Route</a></li>

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
    <p class="breadcrumbs">
        <span class="mr-2">
            <a href="/">Home <i class="ion-ios-arrow-forward"></i>
            </a>
        </span>
        <span class="mr-2"><a href="/client/route">Route</a> <i class="ion-ios-arrow-forward"></i></span>
        <span class="mr-2"><a href="/client/lich-trinh-tuyen/{{$id_lich}}">Trip</a><i class="ion-ios-arrow-forward"></i></span>
        <span class="mr-2">Choose Seat<i class="ion-ios-arrow-forward"></i></span>
    </p>
    <h1 class="mb-3 bread">Chọn Chổ Ngồi</h1>
@endsection
@section('noi_dung')
<div id="app">
    <div class="row">
        <div class="col">
            <table class="table table-bordered" id="table_ghe">
                <thead >
                    <div class="row">
                        <div class="col">
                            <h3><b>Tài Xế</b></h3>
                        </div>
                        <div class="col"></div>
                        <div class="col"></div>
                        <div class="col text-end">
                            <h3><b>Cửa Ra Vào</b></h3>
                        </div>
                    </div>
                </thead>
                <tbody>
                    <template v-for="i in hang_ngang">
                        <tr>
                            <template v-for="j in hang_doc">
                                <template v-if="list_ghe[(i - 1) * hang_doc + (j - 1)] !== undefined && list_ghe[(i - 1) * hang_doc + (j - 1)].trang_thai == 1">
                                    <th class="change text-center aligin-middle" style="height: 70px; font-size: 30px; background-color: #DEF5E5" v-on:click="datGhe(list_ghe[(i - 1) * hang_doc + (j - 1)].id)">@{{ list_ghe[(i - 1) * hang_doc + (j - 1)].ten_ghe }}</th>
                                    <th style="width:3px"></th>
                                </template>
                                <template v-else>
                                    <th class="change text-center aligin-middle" style="height: 70px; font-size: 30px; background-color: #a8d82e" v-on:click="huyGhe(list_ghe[(i - 1) * hang_doc + (j - 1)].id)">@{{ list_ghe[(i - 1) * hang_doc + (j - 1)].ten_ghe }}</th>
                                    <th style="width:3px"></th>
                                </template>
                            </template>
                        </tr>

                    </template>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col text-right"><button class="btn btn-primary" v-on:click="XemVeXe()">Xem vé xe đã đặt</button></div>
        {{-- <a class="btn btn-primary" v-bind:href="">Xem vé đã đặt</a> --}}
    </div>
</div>
@endsection
@section('js')
    <script>
        new Vue({
            el      :   '#app',
            data    :   {
                hang_doc    : {{$hang_doc}},
                hang_ngang  : {{$hang_ngang}},
                id_xe       : {{$id_xe}},
                list_id_ghe : '',
                list_ghe    : [],
                id_lich     : 0,
            },
            created()   {
                this.id_lich = window.location.pathname.substring(19);
                this.loadGhe();
            },
            methods :   {
                loadGhe() {
                    axios
                        .get('/client/data-ghe/' + this.id_lich)
                        .then((res) => {
                            this.list_ghe = res.data.danh_sach_ghe;
                        });
                },
                datGhe(id) {
                    var payload = {
                        'id'    : id
                    };

                    axios
                    .post('/client/dat-ghe', payload)
                        .then((res) => {
                            if(res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadGhe();
                            } else {
                                toastr.error(res.data.message);
                                setTimeout(() => {
                                    window.location.href = '/login';
                                }, "1400");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                huyGhe(id) {
                    var payload = {
                        'id'    : id
                    };

                    axios
                    .post('/client/huy-ghe-dat', payload)
                        .then((res) => {
                            if(res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadGhe();
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
                XemVeXe() {
                    window.location.href = '/client/xem-ve-xe/'+this.id_lich;
                }
            },
        });
    </script>
@endsection
