<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yoeunes\Toastr\Facades\Toastr;

class AdminMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $check = Auth::guard('admin')->check();
        if ($check) {
            return $next($request);
        }
        Toastr::error('Bạn cần đăng nhập hệ thống trước!');
        return redirect('/admin/login');
    }
}
