<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Tests",
 *     description="API Endpoints for managing tests"
 * )
 */
class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tests",
     *     tags={"Tests"},
     *     summary="Get all tests",
     *     @OA\Response(
     *         response=200,
     *         description="List of tests",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="List of tests retrieved successfully."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Test")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = Test::all();
        return response()->json([
            'message' => 'List of tests retrieved successfully.',
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/tests/{id}",
     *     tags={"Tests"},
     *     summary="Get a specific test",
     *     @OA\Parameter(name="id", in="path", required=true, description="ID of the test", @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Test retrieved",
     *         @OA\JsonContent(ref="#/components/schemas/Test")
     *     ),
     *     @OA\Response(response=404, description="Test not found")
     * )
     */
    public function show($id)
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }
        return response()->json([
            'message' => 'Test retrieved successfully.',
            'data' => $test,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tests",
     *     tags={"Tests"},
     *     summary="Create a new test",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Test Name"),
     *             @OA\Property(property="description", type="string", example="Test description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Test created",
     *         @OA\JsonContent(ref="#/components/schemas/Test")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test = Test::create($validatedData);
        return response()->json([
            'message' => 'Test created successfully.',
            'data' => $test,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/tests/{id}",
     *     tags={"Tests"},
     *     summary="Update a specific test",
     *     @OA\Parameter(name="id", in="path", required=true, description="ID of the test", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Test Name"),
     *             @OA\Property(property="description", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Test updated",
     *         @OA\JsonContent(ref="#/components/schemas/Test")
     *     ),
     *     @OA\Response(response=404, description="Test not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update($validatedData);
        return response()->json([
            'message' => 'Test updated successfully.',
            'data' => $test,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tests/{id}",
     *     tags={"Tests"},
     *     summary="Delete a specific test",
     *     @OA\Parameter(name="id", in="path", required=true, description="ID of the test", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Test deleted successfully."),
     *     @OA\Response(response=404, description="Test not found")
     * )
     */
    public function destroy($id)
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }

        $test->delete();
        return response()->json(['message' => 'Test deleted successfully.']);
    }
}