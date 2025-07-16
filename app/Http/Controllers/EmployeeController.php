<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $designations = Designation::all();
        $shifts = Shift::all();

        return view('admin.emp-create-edit', [
            'departments' => $departments,
            'designations' => $designations,
            'shifts' => $shifts,
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
            'emp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'emp_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'emp_national_id' => 'nullable|string|max:255',
            'emp_contact_number' => 'nullable|string|max:20',
            'emp_date_of_birth' => 'nullable|date',
            'emp_joining_date' => 'nullable|date',
            'emp_starting_salary' => 'nullable|numeric',
            'emp_resignation_date' => 'nullable|date|required_if:emp_is_resigned,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['emp_image', 'emp_file', 'emp_is_resigned']);
        $data['emp_is_resigned'] = $request->has('emp_is_resigned');

        // Handle image upload
        if ($request->hasFile('emp_image')) {
            $imagePath = $request->file('emp_image')->store('employee_images', 'public');
            $data['emp_image'] = $imagePath;
        }

        // Handle document upload
        if ($request->hasFile('emp_file')) {
            $filePath = $request->file('emp_file')->store('employee_documents', 'public');
            $data['emp_file'] = $filePath;
        }

        Employee::create($data);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $designations = Designation::all();
        $shifts = Shift::all();

        return view('employees.create-edit', [
            'employee' => $employee,
            'departments' => $departments,
            'designations' => $designations,
            'shifts' => $shifts,
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['emp_image', 'emp_file', 'emp_is_resigned']);
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

        $employee->update($data);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }
}