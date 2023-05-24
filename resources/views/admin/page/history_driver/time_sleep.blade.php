@extends('admin.share.master')
@section('noi_dung')
<div class="container">
    <div class="row" id="app">
        {{-- <div class="col-md-3"></div> --}}
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Thời gian bắt đầu ngủ</th>
                        <th class="text-center">Thời gian kết thúc ngủ</th>
                        <th class="text-center ">Ngày ngủ gật</th>
                        <th class="text-center">Tên Tài Xế</th>
                        <th class="text-center">Ảnh</th>
                        {{-- <th class="text-center">Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(v, key) in listHistory">
                        <tr class="text-center">
                            <th class="text-center align-middle">@{{ key + 1 }}</th>
                            <td class="align-middle">@{{ v.sleep_time_start }}</td>
                            <td class="align-middle">@{{ v.sleep_time_end }}</td>
                            <td class="align-middle">@{{ v.created_at}}</td>
                            <td class="align-middle">@{{ v.ho_va_ten}}</td>
                            <td class="align-middle"><img v-bind:src="v.link" alt="" style="width:80px;height:80px"></td>
                                {{-- <td class="text-center text-nowrap align-middle"> --}}
                                {{-- <button class="btn btn-info">Cập Nhật</button> --}}
                                {{-- <a ><i class="fa-regular fa-pen-to-square fa-xl " style="color: #2baebf;"></i></i></a>
                                <a v-on:click="abc()"><i class="fa-solid fa-trash fa-xl" style="color: #f00a2c;"></i></a> --}}
                                {{-- <button  button-icon name="trash-outline"></button> --}}
                            {{-- </td> --}}
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
        el      :   '#app',
        data    :   {
            listHistory :   [],
        },
        created()   {
            this.loadData();
        },
        methods :   {
            loadData() {
                axios
                    .get('/admin/history-driver/data')
                    .then((res) => {
                        this.listHistory= res.data.data;
                    });
            },
        },
    });
</script>
@endsection
