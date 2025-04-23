<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function showUsers()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    public function showEditUser($id = null)
    {
        // nếu không có id thì về danh sách
        if (! $id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Không tìm thấy người dùng');
        }

        $user = User::find($id);

        if (! $user) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Không tìm thấy người dùng');
        }

        return view('admin.users-edit', compact('user'));
    }

    public function editUser(UserRequest $request)
    {
        $data = $request->only(['id', 'first_name', 'last_name', 'address', 'status']);
        // dd($data);
        $user = User::find($data['id']);

        if (! $user) {
            return back()->with('error', 'Có lỗi xảy ra.');
        }

        $user->first_name = $data['first_name'];
        $user->last_name  = $data['last_name'];
        $user->status     = $data['status'];
        $user->address    = $data['address'];
        $user->save();

        return redirect()->route('admin.users.edit')->with('success', 'Cập nhật người dùng thành công');
    }

    public function searchUser(Request $request)
    {
        $search = $request->search ? "$request->search" : '';
        if ($request->type_search == 'hoTen') {
            $users = User::where('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orderBy('status', 'ASC')
                ->paginate(20);
        } else if ($request->type_search == 'email') {
            $users = User::where('email', 'LIKE', "%$search%")
                ->orderBy('status', 'ASC')
                ->paginate(20);
        } else {
            $users = User::paginate(15);
        }

        return view('admin.users', compact('users'));
    }

}
