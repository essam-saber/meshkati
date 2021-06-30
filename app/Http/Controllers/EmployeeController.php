<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Mail\WelcomeEmail;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        if(!auth()->user()->hasPermissionTo('read_employees')) abort(403);

        $users = User::latest()->paginate(10);

        return view('pages.employees.index')->with([
            'employees' => $users,
            'page_title' => 'Employees'
        ]);
    }

    public function create()
    {
        $roles = Role::all();

        return view('pages.employees.create')->with([
            'page_title' => 'Create new employee',
            'roles' => $roles
        ]);
    }

    public function edit(int $employeeId)
    {
        if(!auth()->user()->hasPermissionTo('edit_employees')) abort(403);

        if ($employeeId == auth()->id()) {
            abort(403);
        }

        $employee = User::where('id', $employeeId)->firstOrFail();
        $roles = Role::all();

        return view('pages.employees.edit')->with([
            'page_title' => 'Edit employee',
            'employee' => $employee,
            'roles' => $roles
        ]);
    }

    public function update(UpdateEmployeeRequest $request, $employeeId)
    {
        if(!auth()->user()->hasPermissionTo('edit_employees')) abort(403);

        $plainPassword = mt_rand(100000, 999999);
        $request['plain_password'] = $plainPassword;
        $employee = User::where('id', $employeeId)->firstOrFail();
        $employee->update(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)]);
        $role = Role::where('id', $request->role)->firstOrFail();

        $employee->syncRoles($role);
        \Mail::to($request->email)->send(new WelcomeEmail($request));
        return back()->with(['success' => 'Employee information has been updated successfully!']);

    }

    public function store(CreateEmployeeRequest $request)
    {
        if(!auth()->user()->hasPermissionTo('create_employees')) abort(403);

        try {
            $plainPassword = mt_rand(100000, 999999);
            $formData = $request->only('name', 'email');
            $formData['password'] = bcrypt($plainPassword);
            $formData['plain_password'] = $plainPassword;
            $user = User::create($formData);
            $role = Role::where('id', $request->role)->firstOrFail();
            $user->assignRole($role);
            \Mail::to($formData['email'])->send(new WelcomeEmail($formData));
            return redirect()->route('employees.index')->with(['success' => 'The employee has been created successfully!']);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function destroy(Request $request, $employeeId)
    {
        if(!auth()->user()->hasPermissionTo('delete_employees')) abort(403);
        if(auth()->id() === $employeeId) abort(403);
        $user = User::where('id', $employeeId)->firstOrFail();
        $user->delete();
        return back()->with(['success' => 'The employee has been delete successfully!']);
    }
}
