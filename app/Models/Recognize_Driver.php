<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recognize_Driver extends Model
{
    use HasFactory;
    protected $table = 'test';

    protected $fillable = [
        'name',
    ];
}
