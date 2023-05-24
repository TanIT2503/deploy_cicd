<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xe extends Model
{
    use HasFactory;
    protected $table = 'xe';
    protected $fillable = [
        'bien_so_xe',
        'tinh_trang',
        'hang_doc',
        'hang_ngang',
    ];
}
