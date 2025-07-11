<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'permissions')->paginate(15);
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.create', compact('roles', 'permissions'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->assignRole($validated['role']);
        // Permission logic
        if ($validated['role'] === 'Admin') {
            $user->syncPermissions(Permission::all());
        } else {
            $role = Role::where('name', $validated['role'])->first();
            $defaultPerms = $role ? $role->permissions->pluck('name')->toArray() : [];
            $customPerms = $validated['permissions'] ?? [];
            $user->syncPermissions(array_unique(array_merge($defaultPerms, $customPerms)));
        }
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $userPermissions = $user->permissions->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        $user->syncRoles([$validated['role']]);
        // Permission logic
        if ($validated['role'] === 'Admin') {
            $user->syncPermissions(Permission::all());
        } else {
            $role = Role::where('name', $validated['role'])->first();
            $defaultPerms = $role ? $role->permissions->pluck('name')->toArray() : [];
            $customPerms = $validated['permissions'] ?? [];
            $user->syncPermissions(array_unique(array_merge($defaultPerms, $customPerms)));
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function permissions()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.permissions', compact('users', 'roles', 'permissions'));
    }
    public function assignPermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $user = User::findOrFail($validated['user_id']);
        $user->syncPermissions($validated['permissions'] ?? []);
        return back()->with('success', 'Permissions updated.');
    }
    public function revokePermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name',
        ]);
        $user = User::findOrFail($validated['user_id']);
        $user->revokePermissionTo($validated['permission']);
        return back()->with('success', 'Permission revoked.');
    }
} 