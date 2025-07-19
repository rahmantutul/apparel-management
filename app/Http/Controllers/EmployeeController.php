<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $employees = Employee::paginate(15);
        return view('admin.emp_index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $designations = Designation::all();
        $shifts = Shift::all();
        $roles = Role::all();

        return view('admin.emp-create-edit', [
            'departments' => $departments,
            'designations' => $designations,
            'shifts' => $shifts,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_name' => 'required|string|max:255',
            'emp_email' => 'nullable|email|unique:employees,emp_email',
            'emp_id' => 'nullable|string|unique:employees,emp_id',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'emp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'emp_file' => 'nullable|file|max:5120|extensions:pdf,doc,docx,txt',
            'emp_national_id' => 'nullable|string|max:255',
            'emp_contact_number' => 'nullable|string|max:20',
            'emp_date_of_birth' => 'nullable|date',
            'emp_joining_date' => 'nullable|date',
            'emp_starting_salary' => 'nullable|numeric',
            'emp_resignation_date' => 'nullable|date|required_if:emp_is_resigned,1',
            
            'username' => 'required_if:create_user_account,1|string|max:255|unique:users,username',
            'password' => 'required_if:create_user_account,1|string|min:8|confirmed',
            'role_id' => 'required_if:create_user_account,1|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['emp_image', 'emp_file', '_token', 'username', 'email', 'password', 'password_confirmation', 'role_id', 'create_user_account']);
        $data['emp_is_resigned'] = $request->has('emp_is_resigned');

        DB::beginTransaction();

        try {
            // Handle image upload
            if ($request->hasFile('emp_image')) {
                $image = $request->file('emp_image');
                $filename = 'emp_'.time().'.'.$image->getClientOriginalExtension();
                $path = $image->storeAs('employee_images', $filename, 'public');
                $data['emp_image'] = $path;
            }

            // Handle document upload
            if ($request->hasFile('emp_file')) {
                $file = $request->file('emp_file');
                $filename = 'doc_'.time().'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('employee_documents', $filename, 'public');
                $data['emp_file'] = $path;
            }

            // Create employee
            $employee = Employee::create($data);

            // Create user account if requested
            if ($request->create_user_account) {
                // Create the user
                $user = User::create([
                    'username' => $request->username,
                    'name' => $request->emp_name,
                    'email' => $request->emp_email,
                    'phone' => $request->emp_contact_number,
                    'password' => Hash::make($request->password),
                    'employee_id' => $employee->id
                ]);

                // Attach the role (for many-to-many relationship)
                if ($request->role_id) {
                    $user->roles()->attach($request->role_id);
                }

                // Link user to employee
                $employee->update(['user_id' => $user->id]);
            }

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded files if error occurs
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }
            
            return redirect()->back()
                ->with('error', 'Error creating employee: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('admin.emp-create-edit', [
            'employee' => $employee->load('user.roles'), // Eager load relationships
            'departments' => Department::all(),
            'designations' => Designation::all(),
            'shifts' => Shift::all(),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'emp_name' => 'required|string|max:255',
            'emp_email' => 'nullable|email|unique:employees,emp_email,' . $employee->id,
            'emp_id' => 'nullable|string|unique:employees,emp_id,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'emp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'emp_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'emp_national_id' => 'nullable|string|max:255',
            'emp_contact_number' => 'nullable|string|max:20',
            'emp_date_of_birth' => 'nullable|date',
            'emp_joining_date' => 'nullable|date',
            'emp_starting_salary' => 'nullable|numeric',
            'emp_resignation_date' => 'nullable|date|required_if:emp_is_resigned,1',
            'username' => 'nullable|string|max:255|unique:users,username,' . optional($employee->user)->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['emp_image', 'emp_file', 'emp_is_resigned', 'username', 'password', 'role_id']);
        $data['emp_is_resigned'] = $request->has('emp_is_resigned');

        // Handle image upload
        if ($request->hasFile('emp_image')) {
            // Delete old image if exists
            if ($employee->emp_image) {
                Storage::disk('public')->delete($employee->emp_image);
            }
            
            $imagePath = $request->file('emp_image')->store('employee_images', 'public');
            $data['emp_image'] = $imagePath;
        }

        // Handle document upload
        if ($request->hasFile('emp_file')) {
            // Delete old document if exists
            if ($employee->emp_file) {
                Storage::disk('public')->delete($employee->emp_file);
            }
            
            $filePath = $request->file('emp_file')->store('employee_documents', 'public');
            $data['emp_file'] = $filePath;
        }

        // Update employee
        $employee->update($data);

        // Handle user account update
        if ($employee->user) {
            $userData = [
                'name' => $request->emp_name,
                'email' => $request->emp_email,
                'phone' => $request->emp_contact_number,
            ];

            if ($request->filled('username')) {
                $userData['username'] = $request->username;
            }

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $employee->user->update($userData);

            // Update role if provided
            if ($request->filled('role_id')) {
                $employee->user->roles()->sync([$request->role_id]);
            }
        } elseif ($request->create_user_account) {
            // Create new user account if requested
            $user = User::create([
                'username' => $request->username,
                'name' => $request->emp_name,
                'email' => $request->emp_email,
                'phone' => $request->emp_contact_number,
                'password' => Hash::make($request->password),
                'employee_id' => $employee->id
            ]);

            if ($request->filled('role_id')) {
                $user->roles()->attach($request->role_id);
            }

            $employee->update(['user_id' => $user->id]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }
    public function destroy($id)
    {
        $user = Employee::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully.'
        ]);
    }
}