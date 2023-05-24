<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class KhachHang extends Authenticatable
{
    use HasFactory;
    protected $table = 'khach_hangs';
    protected $fillable = [
        'ho_va_ten',
        'ho_lot',
        'ten',
        'id_xe',
        'email',
        'password',
        'so_dien_thoai',
        'hash_mail',
        'gioi_tinh',
        'loai_tai_khoan',
        'hash_reset',
    ];
}
