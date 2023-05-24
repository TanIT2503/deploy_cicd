<?php

namespace App\Http\Controllers;

use App\Models\Tuyen;
use Illuminate\Http\Request;

class TuyenController extends Controller
{
    public function index()
    {
        return view('admin.page.tuyen.index');
    }

    public function data()
    {

        $data = Tuyen::get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        Tuyen::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã thêm mới tuyến xe thành công!',
        ]);
    }


    public function update(Request $request)
    {
        $data = $request->all();
        $phim = Tuyen::where('id', $request->id)->first();
        $phim->update($data);

        return response()->json([
            'status'    => true,
        ]);
    }

    public function destroy(Request $request)
    {
        Tuyen::where('id', $request->id)->first()->delete();

        return response()->json([
            'status'    => true,
        ]);
    }

    public function status(Request $request)
    {
        $tuyen = Tuyen::find($request->id);
        if($tuyen) {
            if($request->tinh_trang == 0) {
                $tuyen->tinh_trang = 1;
            } else if($request->tinh_trang == 1) {
                $tuyen->tinh_trang = 2;
            } else {
                $tuyen->tinh_trang = 0;
            }
            $tuyen->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã đổi trạng thaisa thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Tuyến này không tồn tại!',
            ]);
        }
    }
}
