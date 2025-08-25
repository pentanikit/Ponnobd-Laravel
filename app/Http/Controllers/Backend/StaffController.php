<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::where('user_type', 'staff')->latest()->paginate();
        return view('backend.staff.index', compact('staffs'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('backend.staff.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ]);
        
        $user = new User();
        $user->username = str($request->email)->before('@');
        $user->name = $request->name;
        $user->user_type = 'staff';
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();

        $role = Role::find($request->role_id);
        $user->assignRole($role->name);


        return to_route('staff.index')->with('success', 'Staff added successfully!');
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('backend.staff.edit', compact('staff', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id,
            'password' => 'nullable|min:6',
            'role_id' => 'required'
        ]);



        $user = User::findOrFail($id);
        $user->username = str($request->email)->before('@');
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password != null ? bcrypt($request->password) : $user->password;
        $user->save();

        $role = Role::find($request->role_id);
        $user->syncRoles([$role->name]);

        return to_route('staff.index')->with('success', 'Staff updated successfully!');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return back()->with('success', 'Staff deleted successfully!');
    }
}
