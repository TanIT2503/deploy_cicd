<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichTrinh extends Model
{
    use HasFactory;
    protected $table = 'lich_trinhs';
    protected $fillable = [
        'id_tuyen',
        'id_xe',
        'id_tai_xe',
        'thoi_luong_hieu_chinh',
        'thoi_luong_nghi',
        'thoi_gian_bat_dau',
        'ngay_khoi_chay',
        'tinh_trang',
    ];
}
