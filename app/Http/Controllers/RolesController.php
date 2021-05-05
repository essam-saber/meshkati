<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        if(!auth()->user()->hasPermissionTo('read_roles')) abort(403);

        $roles = Role::all();
        return view('pages.roles.index')->with([
            'roles' => $roles,
            'page_title' => 'All Roles'
        ]);
    }

    public function create()
    {
        if(!auth()->user()->hasPermissionTo('create_roles')) abort(403);

        $permissions = $this->extractPermissionsFromModulesConfig();

        return view('pages.roles.create')->with([
            'page_title' => 'Create new role',
            'permissions' => $permissions
        ]);
    }

    public function edit($roleId)
    {
        if(!auth()->user()->hasPermissionTo('edit_roles')) abort(403);

        $permissions = $this->extractPermissionsFromModulesConfig();

        $role = Role::with('permissions')->where('id', $roleId)->firstOrFail();
        $rolePermissions = $role->permissions->pluck('name');

        return view('pages.roles.edit')->with([
            'page_title' => 'Edit role',
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function update(UpdateRoleRequest $request, $roleId)
    {
        if(!auth()->user()->hasPermissionTo('edit_roles')) abort(403);

        $role = Role::where('id', $roleId)->firstOrFail();
        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role->syncPermissions($permissions);
        $role->update(['name' => $request->name]);
        return back()->with(['success' => 'The role has been created successfully']);

    }

    public function store(CreateRoleRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create_roles')) abort(403);

        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')->with(['success' => 'The role has been created successfully']);
    }

    /**
     * @return mixed
     */
    private function extractPermissionsFromModulesConfig()
    {
        $permissions = [];
        collect(config('modules'))->each(function ($value, $key) use (&$permissions) {
            collect($value)->each(function ($v) use ($key, &$permissions) {
                if (!array_key_exists($key, $permissions)) {
                    $permissions[$key] = [];
                }
                $permissions[$key][] = "{$v}_{$key}";
            });
        });
        return $permissions;
    }

}
