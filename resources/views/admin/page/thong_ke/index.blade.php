@extends('admin.share.master')
@section('noi_dung')
    <div id="app">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/thong-ke" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-md-5">
                                    <label for="exampleDataList" class="form-label">Từ Ngày</label>
                                    <input class="form-control" name="day_begin" type="date" placeholder="Type to search..." value="{{ $tu_ngay }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="exampleDataList" class="form-label">Đến Ngày</label>
                                    <input class="form-control" name="day_end" type="date" placeholder="Type to search..." value="{{ $den_ngay }}">
                                </div>
                                <div class="col-md-2" style="margin-top: 3px">
                                    <label for="exampleDataList" class="form-label"></label>
                                    <button class="btn btn-success" type="submit" style="width: 100%"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Bảng Thống Kê
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Tên tài xế</th>
                                        <th>Số lần ngủ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach ($data as $key => $value)
                                        <tr>
                                            <th class="text-center align-middle">{{ $key + 1 }}</th>
                                            <td class="align-middle">{{ $value->ho_va_ten }}</td>
                                            <td class="text-center align-middle">{{ $value->so_luong }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Chart Thống Kê
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');
        var lables = {!! json_encode($array_ten) !!};
        var datas = {!! json_encode($array_so_luong) !!};
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: lables,
                datasets: [{
                    label: 'Lần ngủ',
                    data: datas,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
