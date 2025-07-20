<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Traits\Loggable;
use Spatie\Activitylog\Models\Activity;
class UserController extends Controller
{
     use Loggable;
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users', compact('users','roles'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'roles' => $user->roles // Include roles in response
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        // Create user
        $user = User::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => bcrypt($validated['password']),
        ]);

        // Assign role to the user
        $role = Role::findById($validated['role']);
        $user->assignRole($role);

        $user->created_at_formatted = $user->created_at->format('Y-m-d');
        
        return response()->json([
            'success' => true,
            'message' => 'User added successfully!',
            'user' => $user,
            'role' => $role->name,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);

        $data = $request->only(['name', 'username', 'email', 'phone']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        $role = Role::findById($request->role);
        $user->syncRoles($role);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'user' => $user,
            'role' => $role->name,
        ]);
    }

    public function profile_edit(){
        $user = Auth::user();
        $roleId = $user->roles->first()->id;
        return view('admin.edit_profile',compact('user','roleId'));
    }

    public function log_index()
    {
        $activities = Activity::with(['causer', 'subject'])
            ->latest()
            ->paginate(20);

        return view('admin.log_index', compact('activities'));
    }
}
