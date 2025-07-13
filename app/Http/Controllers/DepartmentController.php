<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:departments']);
        
        Department::create($request->all());
        
        return response()->json(['message' => 'Department created successfully']);
    }

    public function edit(Department $department)
    {
        return response()->json($department);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate(['name' => 'required|unique:departments,name,'.$department->id]);
        
        $department->update($request->all());
        
        return response()->json(['message' => 'Department updated successfully']);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(['message' => 'Department deleted successfully']);
    }
}
