<?php

namespace App\Http\Controllers;

use App\Http\Resources\studentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return new studentResource($students, "Success", "List of students");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return new studentResource(null, 'Failed', $validator->errors());
        }

        $student = Student::create($request->all());
        return new studentResource($student, 'Success', 'Student creaated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if ($student) {
            return new studentResource($student, 'Success', 'Student found');
        } else {
            return new studentResource(null, 'Failed', 'Student not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

    if (!$student) {
        return new studentResource(null, 'Failed', 'Student not found');
    }

    $validator = Validator::make($request->all(), [
        'nim' => 'sometimes|required',
        'name' => 'sometimes|required',
        'email' => 'sometimes|required',
        'address' => 'sometimes|required',
        'phone' => 'sometimes|required',
    ]);

    if ($validator->fails()) {
        return new studentResource(null, 'Failed', $validator->errors());
    }

    $student->update($request->all());

    return new studentResource($student, 'Success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

    if (!$student) {
        return new studentResource(null, 'Failed', 'Student not found');
    }

    $student->delete();

    return new studentResource(null, 'Success', 'Student deleted successfully');
    }
}
