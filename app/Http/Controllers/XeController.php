<?php

namespace App\Http\Controllers;

use App\Models\Ghe;
use App\Models\GheBan;
use App\Models\Xe;
use Illuminate\Http\Request;

class XeController extends Controller
{

    public function index()
    {
        return view('admin.page.xe.index');
    }

    public function create(Request $request)
    {
        // 1. Ta sẽ thêm mới xe
        $newXe = Xe::create([
            'bien_so_xe'    => $request->bien_so_xe,
            'tinh_trang'    => $request->tinh_trang,
            'hang_ngang'    => $request->hang_ngang,
            'hang_doc'      => $request->hang_doc,
        ]);

        for($dong = 1; $dong <= $request->hang_ngang; $dong++) {
            $chu = chr($dong + 64);//đổi thành chữ
            for($cot = 1; $cot <= $request->hang_doc; $cot++) {
                $ten_ghe = $chu . $cot;
                Ghe::create([
                    'ten_ghe'       => $ten_ghe,
                    'tinh_trang'    => 1,
                    'id_xe'         => $newXe->id,
                ]);
            }
        }

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã thêm thành công!'
        ]);
    }

    public function DataXe()
    {
        $data = Xe::get();

        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }


    public function changeStatus($id)
    {
        $xe = Xe::where('id', $id)->first();

        if($xe) {
            $xe->tinh_trang = !$xe->tinh_trang;
            $xe->save();
        }

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã đổi trạng thái thành công!',
        ]);
    }

    public function DataGhe($id_xe)
    {
        $xe     = Xe::where('id', $id_xe)->first();
        $data   = Ghe::where('id_xe', $id_xe)->get();

        return response()->json([
            'danh_sach_ghe'     => $data,
            'thong_tin_xe'      => $xe,
        ]);
    }

    public function destroy(Request $request)
    {
        $xe = Xe::where('id', $request->id)->first();

        if($xe) {
            Ghe::where('id_xe', $request->id)->delete();
            $xe->delete();
        }
    }

    public function update(Request $request)
    {
        $xe = Xe::where('id', $request->id)->first();

        if($xe) {
            $xe->bien_so_xe   = $request->bien_so_xe;
            $xe->tinh_trang  = $request->tinh_trang;
            $xe->hang_ngang  = $request->hang_ngang;
            $xe->hang_doc    = $request->hang_doc;
            $xe->save();

            // Xóa sạch ghế trong Xe
            Ghe::where('id_xe', $request->id)->delete();
            // Tạo mới lại số ghế $request->hang_doc * $request->hang_ngang
            for($dong = 1; $dong <= $request->hang_ngang; $dong++) {
                $chu = chr($dong + 64);
                for($cot = 1; $cot <= $request->hang_doc; $cot++) {
                    $ten_ghe = $chu . $cot;
                    Ghe::create([
                        'ten_ghe'       => $ten_ghe,
                        'tinh_trang'    => 1,
                        'id_xe'         => $request->id,
                    ]);
                }
            }
        }

        return response()->json([
            'status' => true,
            'messs'  => "Cập nhập xe thành công!",
        ]);
    }
}
