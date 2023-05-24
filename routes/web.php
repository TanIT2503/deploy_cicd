<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\LichTrinhController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\XeController;
use App\Models\Xe;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TuyenController;
use App\Models\KhachHang;

// Route Tài Khoản Admin
Route::get('/admin/image', [AdminController::class, 'test']);

Route::get('/admin/login', [AdminController::class, 'viewLogin']);
Route::post('/admin/login', [AdminController::class, 'actionLogin']);
Route::get('/admin/logout', [AdminController::class, 'logOut']);

Route::get('/required-email', [AdminController::class, 'viewEmail']); //view nhập email để lấy lại
Route::post('/check-email', [AdminController::class, 'checkEmail']); //check xem mail đó có tồn tại ở trong admin không
Route::get('/reset-password/{hash}', [AdminController::class, 'viewReset']); //view nhập mật khẩu mới
Route::post('/reset-password', [AdminController::class, 'actionReset']); //xác nhận đổi mật khẩu
// ,  'middleware' => 'AdminMiddleware'

Route::group(['prefix' => '/admin'], function () {

    //Login quyền admin
    // history driver
    // /admin/history-driver/data
    Route::get('/history',                [AdminController::class, 'history']);
    Route::get('/history-driver/data',    [AdminController::class, 'data_driver']);

    Route::group(['prefix' => '/tuyen'], function () {
        Route::get('/index',   [TuyenController::class, 'index']);
        Route::get('/data',    [TuyenController::class, 'data']);
        Route::post('/create', [TuyenController::class, 'store']); ///admin/tuyen/create
        Route::post('/delete', [TuyenController::class, 'destroy']);
        Route::post('/update', [TuyenController::class, 'update']);
        Route::post('/status', [TuyenController::class, 'status']);
        // Route::get('/thong-ke', [AdminController::class, 'thong_ke']);

    });
    Route::group(['prefix' => '/tai-khoan',  'middleware' => 'AdminMiddleware'], function () {
        Route::get('/index',   [AdminController::class, 'index']);
        Route::get('/data',    [AdminController::class, 'data']);
        Route::post('/create', [AdminController::class, 'create']);
        Route::post('/delete', [AdminController::class, 'destroy']);
        Route::post('/update', [AdminController::class, 'update']);
        Route::post('/status', [AdminController::class, 'status']);

        // Route::get('/thong-ke', [AdminController::class, 'thong_ke']);

    });
    Route::group(['prefix' => '/thong-ke'], function () {
        Route::get('/', [ThongKeController::class, 'index']);
        Route::post('/', [ThongKeController::class, 'search']);
    });

    Route::group(['prefix' => '/xe'], function () {
        Route::get('/index',   [XeController::class, 'index']);
        Route::get('/data-xe',    [XeController::class, 'DataXe']);
        Route::get('/data-ghe/{id_xe}',    [XeController::class, 'DataGhe']);
        Route::get('/change-status/{id}', [XeController::class, 'changeStatus']);
        Route::post('/create', [XeController::class, 'create']);
        Route::post('/delete', [XeController::class, 'destroy']);
        Route::post('/update', [XeController::class, 'update']);
    });
    //  Route::get('/index',   [AdminController::class, 'master']);



    Route::group(['prefix' => '/lich-trinh'], function () {
        Route::get('/index',   [LichTrinhController::class, 'index']);
        Route::get('/data',    [LichTrinhController::class, 'data']);
        Route::post('/create', [LichTrinhController::class, 'create']);
        Route::post('/update', [LichTrinhController::class, 'update']);
        Route::post('/status', [LichTrinhController::class, 'changeStatus']);
        Route::post('/delete', [LichTrinhController::class, 'destroy']);
    });
});

Route::get('/', [KhachHangController::class, 'index']);
Route::get('/login', [KhachHangController::class, 'view_login']);
Route::post('/login', [KhachHangController::class, 'actionLogin']);

Route::post('/dang-ky', [KhachHangController::class, 'actionRegister']);
Route::get('/active/{hash}', [KhachHangController::class, 'actionActive']);

Route::get('/lost-password', [KhachHangController::class, 'viewLostPass']);
Route::post('/lost-password', [KhachHangController::class, 'actionLostPass']);

Route::get('/update-password/{hash_reset}', [KhachHangController::class, 'viewUpdatePass']);
Route::post('/update-password', [KhachHangController::class, 'actionUpdatePass']);

Route::get('/logout', [KhachHangController::class, 'actionLogout']);
Route::group(['prefix' => '/client'], function () {
    //Truc - contact
    Route::get('/contact', [KhachHangController::class, 'view_contact']);
    Route::post('/contact', [KhachHangController::class, 'send_mail']);

    Route::get('/route', [KhachHangController::class, 'view_services']);
    Route::get('/route/data',    [KhachHangController::class, 'data']);

    Route::post('/tim-tuyen-duong', [KhachHangController::class, 'tim_diem_bat_dau']);
    Route::get('/lich-trinh-tuyen/{id}', [KhachHangController::class, 'lich_trinh_tuyen']);

    Route::get('/chon-ghe/{id_xe}/{id_lich}', [KhachHangController::class, 'viewChonXe']);
    Route::get('/data-ghe/{id_lich}', [KhachHangController::class, 'dataGhe']);
    Route::post('/dat-ghe', [KhachHangController::class, 'updateGheBan']);
    Route::post('/huy-ghe-dat', [KhachHangController::class, 'updateHuyDatGhe']);

    Route::get('/xem-ve-xe/{id_lich}', [KhachHangController::class, 'XemVeXe']);
    Route::get('/xem-ve-xe-data', [KhachHangController::class, 'dataVeDaDat']);

});





Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
