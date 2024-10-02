<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\UploadImage;
use App\Models\WolfItem\WolfItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WolfShopController extends Controller
{
    public function uploadImage(Request $request, $productId): JsonResponse
    {
        $params = $request->only(['image']);
        // Validate the request
        $validator = Validator::make(
            $params,
            [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB max size
            ]
        );
        
        if ($validator->fails()) {
            response()->json([
                'message' => $validator->messages(),
            ], 400);
        }

        // Find the product
        $product = WolfItem::query()->find($productId);

        if (empty($product)) {
            return response()->json([
                'message' => 'No item found',
            ], 404);
        }

        // Store the image
        if ($request->file('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueFileName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;

            // Store the file in the public/products folder with the unique file name
            $filePath = $request->file('image')->storeAs('products', $uniqueFileName, 'public');

            $product->image = Storage::url($filePath);
            $product->save();

            // Upload file to Cloud Service asynchronously
            UploadImage::dispatch([
                'item_id' => $product->id,
            ]);

            return response()->json([
                'message' => 'Image uploaded successfully',
                'path' => $product->image,
            ], 200);
        }

        return response()->json([
            'message' => 'No image uploaded',
        ], 400);
    }
}
