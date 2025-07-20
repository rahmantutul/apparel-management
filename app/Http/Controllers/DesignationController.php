<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use App\Traits\Loggable;
class DesignationController extends Controller
{
     use Loggable;
        public function index()
    {
        $designations = Designation::all();
        return view('admin.designations', compact('designations'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:designations']);
        
        Designation::create($request->all());
        
        return response()->json(['message' => 'Designation created successfully']);
    }

    public function edit(Designation $designation)
    {
        return response()->json($designation);
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate(['name' => 'required|unique:designations,name,'.$designation->id]);
        
        $designation->update($request->all());
        
        return response()->json(['message' => 'Designation updated successfully']);
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return response()->json([
            'success' => true,
            'message' => 'Designation deleted successfully'
        ]);
    }
}
