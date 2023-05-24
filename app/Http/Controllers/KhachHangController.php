<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoiMatKhauClientRequest;
use App\Http\Requests\LoginRequest;
use App\Jobs\ContactMailJob;
use App\Jobs\SendMailJob;
use App\Mail\ContactMail;
use App\Mail\QuenMatKhau;
use App\Models\Admin;
use App\Models\Ghe;
use App\Models\GheBan;
use App\Models\KhachHang;
use App\Models\LichTrinh;
use App\Models\Tuyen;
use App\Models\Xe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\License;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Str;

class KhachHangController extends Controller
{
    public function updateHuyDatGhe(Request $request) {
        $khach_hang = Auth::guard('khach_hang')->user();
        if($khach_hang) {
            $check_doi_ghe = GheBan::where('id_khach_hang', $khach_hang->id)->where('id', $request->id)->first();
            if($check_doi_ghe) {
                $check_doi_ghe->trang_thai = 1;
                $check_doi_ghe->ma_giao_dich = null;
                $check_doi_ghe->id_khach_hang = null;
                $check_doi_ghe->save();

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã hủy vé thành công!',
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Ghế này đã có người đặt. Vui lòng chọn ghê khác!',
                ]);
            }
        }

    }

    public function updateGheBan(Request $request) {
        $ngay_hien_tai = Carbon::now()->format('d.m.Y');
        $khach_hang = Auth::guard('khach_hang')->user();
        if($khach_hang) {
            $ghe_ban = GheBan::find($request->id);
            if($ghe_ban) {
                $ghe_ban->trang_thai = 0;
                $ghe_ban->id_khach_hang = $khach_hang->id;
                $ghe_ban->ma_giao_dich = "HD" . (1992123 + $khach_hang->id) . $ngay_hien_tai;
                $ghe_ban->save();
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã đặt vé thành công!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn chưa đăng nhập!',
            ]);
        }
    }

    public function xacNhanDatGhe(Request $request) {
        // dd($request);
        $khach_hang = Auth::guard('khach_hang')->user();
        if($khach_hang) {
            $id_ghe = explode(',', $request->id_ghe);
            $ma_giao_dich = "HD" . (12456 + $id_ghe[0]);

            foreach ($id_ghe as $key => $value) {
                $ghe = Ghe::where('id', $value)->where('tinh_trang', 1)->first();

                if($ghe) {
                    // GheBan::create([
                    //     'ten_ghe'               => $ghe->ten_ghe,
                    //     'id_lich'               => $request->id_lich,
                    //     'id_khach_hang'         => $khach_hang->id,
                    //     'trang_thai'            => 1,
                    //     'ma_giao_dich'          => $ma_giao_dich,
                    // ]);
                    $ghe_ban = GheBan::where('id', $value)->first();
                    $ghe_ban->trang_thai = 2;
                    $ghe_ban->ma_giao_dich = $ma_giao_dich;
                    $ghe_ban->save();
                } else {
                    return response()->json([
                        'status' => 0,
                        'message'   => 'Ghế đang có vẫn đề gì đó. Vui lòng chọn ghế khác!',
                    ]);
                }
            }
        } else {
            return redirect('/login');
        }
    }

    public function data(){
        $tuyen = Tuyen::get();
        return response()->json([
            'tuyen' => $tuyen,
        ]);
    }

    public function DataGhe($id_lich)
    {
        $check = LichTrinh::find($id_lich);
        if($check) {
            $data   = GheBan::where('id_lich', $id_lich)->get();
            return response()->json([
                'danh_sach_ghe'     => $data,
            ]);
        }
    }

    public function viewChonXe($id_xe, $id_lich) {
        $xe = Xe::find($id_xe);
        $hang_doc   = $xe->hang_doc;
        $hang_ngang = $xe->hang_ngang;

        return view('client.chon_xe', compact('id_lich','id_xe','hang_doc','hang_ngang'));
    }

    public function viewUpdatePass($hash_reset)
    {
        $taiKhoan = KhachHang::where('hash_reset', $hash_reset)->first();
        if($taiKhoan) {
            return view('client.kich_hoat_lai_mat_khau', compact('hash_reset'));
        } else {
            toastr()->error('Dữ liệu không tồn tại!');
            return redirect('/login');
        }
    }

    public function actionUpdatePass(Request $request)
    {
        if($request->password != $request->re_password) {
            toastr()->error('Mật khẩu không trùng nhau!');
            return redirect()->back();
        }
        $taiKhoan = KhachHang::where('hash_reset', $request->hash_reset)->first();
        if(!$taiKhoan) {
            toastr()->error('Dữ liệu không tồn tại!');
            return redirect()->back();
        } else {
            $taiKhoan->password   = bcrypt($request->password);
            $taiKhoan->hash_reset = NULL;
            $taiKhoan->save();
            toastr()->success('Đã đổi mật khẩu thành công!');
            return redirect('/login');
        }
    }

    public function viewLostPass()
    {
        return view('client.quen_mat_khau');
    }

    public function actionLostPass(Request $request)
    {
        $taiKhoan   = KhachHang::where('email', $request->email)->first();
        if($taiKhoan) {
            $now    = Carbon::now();
            $time   = $now->diffInMinutes($taiKhoan->updated_at);
            if(!$taiKhoan->hash_reset || $time > 0) {
                $taiKhoan->hash_reset = Str::uuid();
                $taiKhoan->save();

                $link    = env('APP_URL') . '/update-password/' . $taiKhoan->hash_reset;

                Mail::to($taiKhoan->email)->send(new QuenMatKhau($link));
            }
            toastr()->success("Vui lòng kiểm tra email!");
            return redirect('/login');

        } else {
            toastr()->error("Tài khoản không tồn tại!");
            return redirect('/login');
        }
    }


    public function index()
    {
        return view('client.route');
    }

    public function view_login()
    {
        return view('client.login');
    }

    public function actionLogout()
    {
        Auth::guard('khach_hang')->logout();
        Toastr::success('Đã logout thành công!');
        return redirect('/login');
    }

    public function actionLogin(LoginRequest $request)
    {
        $data = $request->all();
        $check = Auth::guard('khach_hang')->attempt($data);
        if ($check) {
            $khach_hang = Auth::guard('khach_hang')->user();
            if ($khach_hang->loai_tai_khoan == -1) {
                Auth::guard('khach_hang')->logout();
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Tài khoản đã bị khóa!',
                ]);
            } else if ($khach_hang->loai_tai_khoan == 0) {
                Auth::guard('khach_hang')->logout();
                return response()->json([
                    'status'    => 2,
                    'message'   => 'Tài khoản chưa được kích hoạt!',
                ]);
            } else {
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã đăng nhập thành công!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Tài khoản hoặc mật khẩu không đúng!',
            ]);
        }
    }


    public function actionRegister(Request $request)
    {
        $data = $request->all();
        $hash = Str::uuid(); // tạo ra 1 biến tên hash kiểu string có 36 ký tự không trùng với nhau
        $data['hash_mail'] = $hash;
        $data['password']  = bcrypt($data['password']);
        $data['ho_va_ten'] = $data['ho_lot'] . " " . $data['ten'];
        KhachHang::create($data);
        // Phân cụm này qua JOB
        $dataMail['ho_va_ten'] = $data['ho_va_ten'];
        $dataMail['email']     = $request->email;
        $dataMail['hash_mail'] = $hash;
        SendMailJob::dispatch($dataMail);

        return response()->json([
            'status'    => 1,
            'message'   => "Đã tạo tài khoản thành công. Vui lòng kiểm tra Email!",
        ]);
    }

    public function actionActive($hash)
    {
        $account = KhachHang::where('hash_mail', $hash)->first();
        if($account && $account->loai_tai_khoan == 0) {
            $account->loai_tai_khoan = 1;
            $account->hash_mail = '';
            $account->save();
            toastr()->success('Đã kích hoạt tài khoản thành công!');
        } else {
            toastr()->error('Thông tin không chính xác!');
        }

        return redirect('/login');
    }

    public function quenMatKhau()
    {
        return view('client.quen_mat_khau');
    }

    public function actionQuenMatKhau(Request $request) {

        $data = $request->all();
        $khach_hang = KhachHang::where('email', $request->email)->first();

        $data['hash_reset'] = Str::uuid();
        if($khach_hang) {
            if(!$khach_hang->hash_reset) {
                $khach_hang->hash_reset = Str::uuid();
                $khach_hang->save();

                $link    = env('APP_URL') . '/quen-mat-khau-client/' . $khach_hang->hash_reset;
                dd($link);
                Mail::to($khach_hang->email)->send(new QuenMatKhau($link));
            }
            toastr()->success("Vui lòng kiểm tra email!");
            return redirect('/login');
        } else {
            toastr()->error('Email không tồn tại!', "Lỗi");
            return redirect('/login');
        }
    }

    public function viewDoiMatKhau($hash_reset)
    {
        return view('client.kich_hoat_lai_mat_khau', compact('hash_reset'));
    }

    public function doiMatKhau(DoiMatKhauClientRequest $request)
    {
        if($request->password != $request->re_password) {
            toastr()->error('Mật khẩu không trùng nhau!');
            return redirect()->back();
        }
        $taiKhoan = KhachHang::where('hash_reset', $request->hash_reset)->first();
        if(!$taiKhoan) {
            toastr()->error('Dữ liệu không tồn tại!');
            return redirect()->back();
        } else {
            $taiKhoan->password   = bcrypt($request->password);
            $taiKhoan->hash_reset = NULL;
            $taiKhoan->save();
            toastr()->success('Đã đổi mật khẩu thành công!');
            return redirect('/login');
        }
    }

    public function view_contact()
    {
        return view('client.contact');
    }

    public function send_mail(Request $request)
    {
        $cus = KhachHang::where('email', $request->email)->first();

        if ($cus) {

            //email gửi phản hồi nằm ở file .env
            $datamail['ho_va_ten'] = $cus->ho_va_ten;
            $datamail['to_mail'] = 'maithithanhtruc0208@gmail.com';     //email nhận phản hồi của khách hàng
            $datamail['so_dien_thoai'] = $cus->so_dien_thoai;
            $datamail['email'] = $cus->email;                           //email của khách hàng sẽ được đưa vào nội dung email
            $datamail['tieu_de'] = $request->tieu_de;
            $datamail['noi_dung'] = $request->noi_dung;

            ContactMailJob::dispatch($datamail);

            return response()->json([
                'status'    => true,
                'message'   => 'Email đã được gửi đi!!!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Email này chưa được đăng kí tài khoản',
            ]);
        }
    }
    public function view_services()
    {
        return view('client.route');
    }
    public function tim_diem_bat_dau(Request $request)
    {
        $tu_dau = $request->tu_dau;
        $den_dau = $request->den_dau;
        $search = 0;

        if ($tu_dau == null){
            $data =  Tuyen::where("diem_tra_khach", 'LIKE', '%'. $den_dau . '%')->get();
            $search = 1;
            if($den_dau == null){
                $data =  Tuyen::get();
                $search = 0;
            }
            // dd($data);
        } elseif ($den_dau == null){
            $data =  Tuyen::where("diem_don_khach", 'LIKE', '%' . $tu_dau . '%')->get();
            $search = 1;
            // dd($data);
        } else {
            $data =  Tuyen::where("diem_don_khach", 'LIKE', '%' . $tu_dau . '%')->where("diem_tra_khach", 'LIKE', '%' . $den_dau . '%')->get();
            $search = 1;
            // dd($data);
        }

        return response()->json([
            'status'    => true,
            'data'      => $data,
            'search'    => $search,
        ]);
    }
    public function lich_trinh_tuyen($id){
        // $lichtrinh = LichTrinh::where('id_tuyen', $id)->get();

        $data = LichTrinh::where('id_tuyen', $id)->join('tuyens', 'tuyens.id', 'lich_trinhs.id_tuyen')->join('xe', 'xe.id', 'lich_trinhs.id_xe')->join('admins', 'admins.id', 'lich_trinhs.id_tai_xe')->where('admins.id_quyen',2)
        ->select('lich_trinhs.*', 'tuyens.ten_tuyen', 'xe.bien_so_xe', 'admins.ho_va_ten')->get();
        return view('client.lich_trinh_tuyen', compact('data'));
    }


    public function XemVeXe($id_lich){
        return view('client.xemvexe', compact('id_lich'));
    }

    public function dataVeDaDat(){
        $khach_hang = Auth::guard('khach_hang')->user();

        if($khach_hang){
            $thongtinve = GheBan::where('id_khach_hang', $khach_hang->id)->join('khach_hangs', 'khach_hangs.id', 'ghe_bans.id_khach_hang')
            ->join('lich_trinhs', 'lich_trinhs.id', 'ghe_bans.id_lich')
            ->join('tuyens', 'tuyens.id', 'lich_trinhs.id_tuyen')
            ->join('admins', 'admins.id', 'lich_trinhs.id_tai_xe')
            ->join('xe', 'xe.id', 'lich_trinhs.id_xe')->get();
            return response()->json([
                'data' =>  $thongtinve,
            ]);
        }
        return response()->json([
            'data' =>  null,
        ]);

    }
}
