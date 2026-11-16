<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerMediaController extends Controller
{
    /**
     * Upload an image or video file via AJAX and return public URL.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:153600'], // 150MB max
            'type' => ['nullable', 'string', 'in:thumbnail,badge,cover,banner,video,gallery,image'],
        ]);

        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => 'Uploaded file is not valid.'], 422);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'mp4', 'mov', 'webm', 'ogg', 'm4v'];

        if (!in_array($extension, $allowedExtensions)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file format. Allowed formats: PNG, JPG, WEBP, GIF, SVG, MP4, MOV, WEBM.'
            ], 422);
        }

        $type = $request->input('type', 'media');
        $filename = $type . '_' . time() . '_' . Str::random(8) . '.' . $extension;

        $targetDir = public_path('uploads/media');
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }

        $file->move($targetDir, $filename);

        $relativeUrl = 'uploads/media/' . $filename;
        $absoluteUrl = asset($relativeUrl);

        return response()->json([
            'success'   => true,
            'url'       => $absoluteUrl,
            'path'      => $relativeUrl,
            'filename'  => $filename,
            'original'  => $file->getClientOriginalName(),
            'is_video'  => in_array($extension, ['mp4', 'mov', 'webm', 'ogg', 'm4v']),
        ]);
    }
}
