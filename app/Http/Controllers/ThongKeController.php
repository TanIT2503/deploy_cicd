<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{

    public function index()
    {

        $data = History::join('admins', 'admins.id', 'time_sleep.drive_id')
            // ->where('time_sleep.drive_id', 1)
            ->select(
                'admins.ho_va_ten',
                'time_sleep.drive_id',
                DB::raw('COUNT(time_sleep.drive_id) as so_luong'),
            )
            ->groupBy('time_sleep.drive_id', 'admins.ho_va_ten')
            ->get();
        // dd($data->toArray());
        $array_ten = [];
        $array_so_luong = [];
        foreach ($data as $key => $value) {
            array_push($array_ten, $value->ho_va_ten);
            array_push($array_so_luong, $value->so_luong);
        }
        // dd($array_ten);
        $tu_ngay = Carbon::today()->format("Y-m-d");
        $den_ngay = Carbon::today()->format("Y-m-d");
        return view('admin.page.thong_ke.index', compact('data', 'array_ten', 'array_so_luong', 'tu_ngay', 'den_ngay'));
    }

    public function search(Request $request)
    {


        $data = History::join('admins', 'admins.id', 'time_sleep.drive_id')
            ->whereDate('time_sleep.created_at', '>=', $request->day_begin)
            ->whereDate('time_sleep.created_at', '<=', $request->day_end)
            ->select(
                'admins.ho_va_ten',
                'time_sleep.drive_id',
                DB::raw('COUNT(time_sleep.drive_id) as so_luong'),
            )
            ->groupBy('time_sleep.drive_id', 'admins.ho_va_ten')
            ->get();
        // dd($data->toArray());
        $array_ten = [];
        $array_so_luong = [];
        foreach ($data as $key => $value) {
            array_push($array_ten, $value->ho_va_ten);
            array_push($array_so_luong, $value->so_luong);
        }

        $tu_ngay = Carbon::parse($request->day_begin)->format("Y-m-d");
        $den_ngay = Carbon::parse($request->day_end)->format("Y-m-d");
        return view('admin.page.thong_ke.index', compact('data', 'array_ten', 'array_so_luong', 'tu_ngay', 'den_ngay'));
    }
}
