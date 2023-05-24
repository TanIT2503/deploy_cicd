<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = 'admins';

    protected $fillable = [
        'email',
        'password',
        'ho_va_ten',
        'ngay_sinh',
        'so_dien_thoai',
        'id_quyen',
        'hash_word',
        'hash_reset'
    ];
}
