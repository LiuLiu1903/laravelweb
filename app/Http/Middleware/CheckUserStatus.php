<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $userStatus = Auth::user()->status;

            switch ($userStatus) {
                case 0:
                    return redirect()->route('login')->with('error', 'Tài khoản của bạn đang chờ phê duyệt.');
                case 2:
                    return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị từ chối.');
                case 3:
                    return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa.');
            }
        }

        return $next($request);
    }
}
