<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ValidateRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::all();
        if ($students->count() > 0) {
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'students' => $students
            ], ResponseAlias::HTTP_OK);
        }
        return response()->json([
            'status' => ResponseAlias::HTTP_NOT_FOUND,
            'students' => 'No record found'
        ], ResponseAlias::HTTP_NOT_FOUND);
    }

    public function createNewStudent(Request $request): JsonResponse
    {
        $validator = (new ValidateRequest)->validateStudentRequest($request);
        if ($validator->fails()) {
            return response()->json([
                'status' => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->messages()
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'message' => 'Successfully create student'
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Exception on createNewStudent=======> ' . $e->getMessage());
        }
        return response()->json([
            'status' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
            'errors' => 'Something went wrong'
        ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getStudentById($id): JsonResponse
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'student' => $student
            ], ResponseAlias::HTTP_OK);
        }

        return response()->json([
            'status' => ResponseAlias::HTTP_NOT_FOUND,
            'message' => 'No such student found...!'
        ], ResponseAlias::HTTP_NOT_FOUND);
    }

    public function updateStudent(Request $request, $id): JsonResponse
    {
        $validator = (new ValidateRequest)->validateStudentRequest($request);
        if ($validator->fails()) {
            return response()->json([
                'status' => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->messages()
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $student = Student::find($id);
            $student->update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'message' => 'Successfully create student'
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Exception on createNewStudent=======> ' . $e->getMessage());
        }

        return response()->json([
            'status' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
            'errors' => 'Something went wrong'
        ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteStudent($id): JsonResponse
    {
        try {
            $student = Student::find($id);
            $student->update([
                'is_active' => false
            ]);

            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'message' => 'Successfully create student'
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Exception on createNewStudent=======> ' . $e->getMessage());
        }

        return response()->json([
            'status' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
            'errors' => 'Something went wrong'
        ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }
}
