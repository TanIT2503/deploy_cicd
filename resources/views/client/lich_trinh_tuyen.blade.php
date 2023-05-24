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
        <span class="mr-2">Route <i class="ion-ios-arrow-forward"></i></span>
        <span class="mr-2">Trip <i class="ion-ios-arrow-forward"></i></span>
    </p>
    <h1 class="mb-3 bread">Lịch chạy </h1>
@endsection
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-3"></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Ngày</th>
                    <th class="text-center">Thời gian</th>
                    <th class="text-center">Biển số xe</th>
                    <th class="text-center">Tài xế</th>
                    {{-- <th>Vé</th> --}}
                    <th class="text-center" style="width: 70px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        <td class="text-center align-middle">{{$value->ngay_khoi_chay}}</td>
                        <td class="text-center align-middle">{{$value->thoi_gian_bat_dau}}</td>
                        <td class="text-center align-middle">{{$value->bien_so_xe}}</td>
                        <td>{{$value->ho_va_ten}}</td>
                        {{-- <td></td> --}}
                        <td class="text-center text-nowrap"><a target="_blank" href="/client/chon-ghe/{{$value->id_xe}}/{{$value->id}}" class="btn btn-primary">Chọn Ghế Cho Xe {{$value->bien_so_xe}}</a></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{-- <div class="col-md-12 ftco-animate">
            <div class="car-list">
                <table class="table">
                    <thead class="thead-primary">
                        <tr class="text-center">
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th class="bg-primary heading">Thời gian</th>
                            <th class="bg-dark heading">Thông tin xe</th>
                            <th class="bg-black heading">Vé</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $v)
                            <tr class="">
                                <td></td>
                                <td class="product-name">
                                    <h3>{{ $v->ten_tuyen }}</h3>
                                    <p class="mb-0 rated">

                                    </p>
                                </td>

                                <td class="price">
                                    <p class="btn-custom"><a href="#">Rent a car</a></p>
                                    <div class="price-rate">
                                        <h3>
                                            <span class="num">Thời gian chạy: </span>
                                            <span class="per">{{ $v->thoi_gian_bat_dau }}</span>
                                        </h3>
                                        <span class="subheading">$3/hour fuel surcharges</span>
                                    </div>
                                </td>

                                <td class="price">
                                    <p class="btn-custom"><a href="#">Rent a car</a></p>
                                    <div class="price-rate">
                                        <h3>

                                            <span class="num">Biển số xe:</span>
                                            <span class="per">{{ $v->bien_so_xe }}</span>
                                        </h3>
                                        <span class="subheading">Tài xế: {{ $v->ho_va_ten }}</span>
                                    </div>
                                </td>

                                <td class="price">
                                    <p class="btn-custom"><a href="#">Rent a car</a></p>
                                    <div class="price-rate">
                                        <h3>
                                            <span class="num"><small class="currency">$</small> 995.99</span>
                                            <span class="per">/per month</span>
                                        </h3>
                                        <span class="subheading">$3/hour fuel surcharges</span>
                                    </div>
                                </td>
                            </tr><!-- END TR-->
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div> --}}
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
                listtime: [],
            },
            created() {
                // this.loadData();
            },
            methods: {


                doiphut(phut) {
                    var gio = (phut - (phut % 60)) / 60;
                    var phut = phut % 60;

                    // this.listtime = time.split(':');
                    var thoi_gian = [gio, phut];
                    thoi_gian = thoi_gian.join("H ");
                    return thoi_gian + 'P';
                },
                thoigian(time) {
                    console.log(time);
                    // this.listtime = time.split(':');
                    // var gio = (delay - (delay % 60)) / 60;
                    // var phut = delay % 60;

                    // var array = [];

                    // this.listtime.forEach(function(value, key) {
                    //     array[key] = parseInt(value);
                    // });

                    // array[0] += gio;
                    // array[1] += phut;

                    // if (array[1] > 60) {
                    //     array[0] += (array[1] - (array[1] % 60)) / 60;
                    //     array[1] = array[1] % 60;
                    // }

                    // array = array.join(":");
                    // return array;
                },
            },
        });
    </script>
@endsection
