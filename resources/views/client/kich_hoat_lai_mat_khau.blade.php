@extends('client.homepage')
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
                <form action="/update-password" method="post">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="hash_reset" value="{{$hash_reset}}">
                        <div class="mb-2">
                            <label for="" class="mb-1">Mật Khẩu Mới</label>
                            <input name="password" type="password" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label for="" class="mb-1">Nhập Lại Mật Khẩu</label>
                            <input name="re_password" type="password" class="form-control">
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
