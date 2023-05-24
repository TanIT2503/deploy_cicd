<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Ghe;
use App\Models\GheBan;
use App\Models\LichTrinh;
use App\Models\Tuyen;
use App\Models\Xe;
use Illuminate\Http\Request;

class LichTrinhController extends Controller
{
    public function index()
    {
        return view('admin.page.lich_trinh.index');
    }

    public function data(){
        $data = LichTrinh::join('tuyens', 'tuyens.id', 'lich_trinhs.id_tuyen')
                         ->select('lich_trinhs.*', 'tuyens.ten_tuyen')
                         ->get();
        $tuyen = Tuyen::get();
        $xe    = Xe::where('tinh_trang', 1)->get();
        $tai_xe    = Admin::where('id_quyen', 2)->get();
        return response()->json([
            'data'  => $data,
            'tuyen' => $tuyen,
            'xe'    => $xe,
            'tai_xe'=> $tai_xe,
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $lich = LichTrinh::create($data);

        $list_ghe = Ghe::where('id_xe', $lich->id_xe)->get();

        // tạo ghế bán
        foreach($list_ghe as $key => $value) {
            GheBan::create([
                'id_lich'       => $lich->id,
                'ten_ghe'       => $value->ten_ghe,
                'co_the_ban'    => 1,
            ]);
        }

        return response()->json([
            'status'    => true,
            'message'   => 'Đã thêm mới tuyến xe thành công!',
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $update_lichtrinh = LichTrinh::where('id', $request->id)->first();
        $update_lichtrinh->update($data);

        return response()->json([
            'status'    => true,
        ]);
    }

    public function changeStatus(Request $request) {
        $data = $request->all();
        $data['tinh_trang'] = $data['dem'];
        $update_lichtrinh = LichTrinh::where('id', $request->id)->first();
        $update_lichtrinh->update($data);

        return response()->json([
            'status'    => true,
            'message'   => "Đãng đổi trạng thái thành công!"
        ]);
    }

    public function destroy(Request $request)
    {
        LichTrinh::where('id', $request->id)->first()->delete();

        return response()->json([
            'status'    => true,
        ]);
    }
}
