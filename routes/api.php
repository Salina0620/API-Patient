<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\API\AuthController;

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
Route::get('/patients', [PatientController::class, 'index']);

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
Route::get('/patients/{id}', [PatientController::class, 'show']);

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
Route::post('/patients', [PatientController::class, 'store']);

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
Route::put('/patients/{id}', [PatientController::class, 'update']);

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
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);