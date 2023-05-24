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
    <p class="breadcrumbs">
        <span class="mr-2">
            <a href="/">Home <i class="ion-ios-arrow-forward"></i>
            </a>
        </span>
        <span class="mr-2"><a href="/client/route">Route</a> <i class="ion-ios-arrow-forward"></i></span>
        <span class="mr-2"><a href="/client/lich-trinh-tuyen/{{ $id_lich }}">Trip</a><i
                class="ion-ios-arrow-forward"></i></span>
        <span class="mr-2">View tickets<i class="ion-ios-arrow-forward"></i></span>
    </p>
    <h1 class="mb-3 bread">Xem vé xe đã đặt</h1>
@endsection
@section('noi_dung')
    <div id="app">
        <div class="row">
            <div class="col">

                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center text-nowrap">
                            <th>Thời gian</th>
                            <th>Tuyến</th>
                            <th>Tài xế</th>
                            <th>Biển số xe</th>
                            <th>Tên ghế</th>
                            <th>Mã giao dịch</th>
                            <th>Giá vé</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(v, key) in thongtinve">
                            <tr class="text-center text-nowrap">
                                <td>@{{ v.thoi_gian_bat_dau }} <br> @{{ v.ngay_khoi_chay }} </td>
                                <td>@{{ v.ten_tuyen }}</td>
                                <td>@{{ v.ho_va_ten }}</td>
                                <td>@{{ v.bien_so_xe }}</td>
                                <td>@{{ v.ten_ghe }}</td>
                                <td>@{{ v.ma_giao_dich }}</td>
                                <td>@{{ v.gia_ve }}</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                id_lich: 0,
                thongtinve: [],
            },
            created() {
                this.id_lich = window.location.pathname.substring(18);
                this.loaddata();
            },
            methods: {

                loaddata() {
                    axios
                        .get('/client/xem-ve-xe-data')
                        .then((res) => {
                            this.thongtinve = res.data.data;
                        });
                    console.log(data);
                },

            },
        });
    </script>
@endsection
