<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuyen extends Model
{
    use HasFactory;
    protected $table = 'tuyens';
    protected $fillable = [
        'ten_tuyen',
        'diem_don_khach',
        'diem_tra_khach',
        'thoi_luong',
        'ngay_khoi_chay',
        'avatar',
        'mo_ta',
        'tinh_trang',
        'gia_ve',
    ];
}
