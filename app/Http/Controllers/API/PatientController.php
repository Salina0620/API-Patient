<?php

namespace App\Http\Controllers\API;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="Patient API",
 *     version="1.0.0",
 *     description="API for managing patient records"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Patient",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="age", type="integer"),
 *     @OA\Property(property="gender", type="string"),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="phone_no", type="string"),
 *     @OA\Property(property="user_id", type="integer")
 * )
 */

class PatientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/patients",
     *     summary="Get all patients",
     *     tags={"Patient"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of patients",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Patient"))
     *     )
     * )
     */
    public function index()
    {
        return Patient::with('user')->get();
    }

    /**
     * @OA\Get(
     *     path="/api/patients/{id}",
     *     summary="Get a specific patient",
     *     tags={"Patient"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient details",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */
    public function show($id)
    {
        $patient = Patient::with('user')->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return $patient;
    }

    /**
     * @OA\Post(
     *     path="/api/patients",
     *     summary="Create a new patient",
     *     tags={"Patient"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"age","gender","address","phone_no"},
     *             @OA\Property(property="age", type="integer", example=30),
     *             @OA\Property(property="gender", type="string", example="male"),
     *             @OA\Property(property="address", type="string", example="123 Main St"),
     *             @OA\Property(property="phone_no", type="string", example="1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation errors"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'age' => 'required|integer',
            'gender' => 'required|string',
            'address' => 'required|string',
            'phone_no' => 'required|string',
        ]);

        $patient = new Patient();
        $patient->user_id = $request->user()->id; // Assuming user is authenticated
        $patient->age = $request->age;
        $patient->gender = $request->gender;
        $patient->address = $request->address;
        $patient->phone_no = $request->phone_no;
        $patient->save();

        return response()->json(['message' => 'Patient created successfully'], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/patients/{id}",
     *     summary="Update a patient",
     *     tags={"Patient"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"age","gender","address","phone_no"},
     *             @OA\Property(property="age", type="integer", example=31),
     *             @OA\Property(property="gender", type="string", example="female"),
     *             @OA\Property(property="address", type="string", example="456 Elm St"),
     *             @OA\Property(property="phone_no", type="string", example="0987654321")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $request->validate([
            'age' => 'required|integer',
            'gender' => 'required|string',
            'address' => 'required|string',
            'phone_no' => 'required|string',
        ]);

        $patient->age = $request->age;
        $patient->gender = $request->gender;
        $patient->address = $request->address;
        $patient->phone_no = $request->phone_no;
        $patient->save();

        return response()->json(['message' => 'Patient updated successfully'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/patients/{id}",
     *     summary="Delete a patient",
     *     tags={"Patient"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully'], 200);
    }
}
