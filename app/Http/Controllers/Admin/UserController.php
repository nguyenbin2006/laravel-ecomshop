<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
    public function index()
    {
        // Lấy tất cả user, trừ admin (giả sử admin có ID là 1)
        // Hoặc lấy tất cả user bao gồm cả admin tùy bạn
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Xóa người dùng
     */
    public function destroy(User $user)
    {
        // Thêm 1 lớp bảo vệ: Không cho admin tự xóa mình
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của mình!');
        }

        // (Bạn có thể thêm logic kiểm tra: nếu user có đơn hàng thì không cho xóa, v.v.)

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Đã xóa người dùng thành công!');
    }
}