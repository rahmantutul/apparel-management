<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\Loggable;
class RoleController extends Controller
{
    use Loggable;
   public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.roles', compact('roles', 'permissions'));
    }
    

    public function edit(Role $role)
    {
        return response()->json([
            'role' => $role->load('permissions'),
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);
        
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully'
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'permissions' => 'required|array',
        ]);
        
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        
        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully'
        ]);
    }
        
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully'
        ]);
    }
}
