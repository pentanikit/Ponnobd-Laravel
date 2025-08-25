<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::where('name', '!=', 'admin')->latest()->paginate();
        return view('backend.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('backend.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1',
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role->syncPermissions($permissions);


        return to_route('roles.index')->with('success', 'Role added successfully!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'permissions' => 'required|array|min:1',
        ]);


        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return to_route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        return back()->with('success', 'Role deleted successfully!');
    }
}
