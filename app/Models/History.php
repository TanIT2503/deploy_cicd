<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'time_sleep';

    protected $fillable = [
        'sleep_time_start',
        'sleep_time_end',
        'drive_id',
        'link',

        ];
}
