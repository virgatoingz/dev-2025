<?php

namespace App\Http\Controllers;

use App\Helper\EncryptionHelper;
use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     summary="Get all products",
     *     description="Returns a list of all products.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="List of products"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = Product::all();
        $responseData = [
           'message' => 'List of products',
            'data' => $data, 
        ];
        $encryptResponse = EncryptionHelper::encrypt(json_encode($responseData));
        return response()->json([
            'data'=>$encryptResponse,
        ]);
    }
}