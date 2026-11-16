<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait HandlesSellerMediaUploads
{
    /**
     * Process all media uploads (thumbnail, cover, video, gallery).
     * Supports both direct form file uploads and AJAX-uploaded URLs.
     */
    protected function processMediaUploads(Request $request, string $prefix = 'item'): array
    {
        $targetDir = public_path('uploads/media');
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }

        $rawGallery = $request->input('gallery');
        $gallery = [];
        if (is_array($rawGallery)) {
            $gallery = $rawGallery;
        } elseif (is_string($rawGallery) && !empty($rawGallery)) {
            $decoded = json_decode($rawGallery, true);
            $gallery = is_array($decoded) ? $decoded : [$rawGallery];
        }

        $media = [
            'thumbnail'   => $request->input('thumbnail') ?: $request->input('logo'),
            'logo'        => $request->input('logo') ?: $request->input('thumbnail'),
            'cover_image' => $request->input('cover_image'),
            'video_url'   => $request->input('video_url'),
            'gallery'     => $gallery,
        ];

        // 1. Thumbnail / Badge file
        if ($request->hasFile('thumbnail_file') && $request->file('thumbnail_file')->isValid()) {
            $f = $request->file('thumbnail_file');
            $name = $prefix . '_thumb_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
            $f->move($targetDir, $name);
            $media['thumbnail'] = 'uploads/media/' . $name;
            $media['logo'] = 'uploads/media/' . $name;
        } elseif ($request->hasFile('logo_file') && $request->file('logo_file')->isValid()) {
            $f = $request->file('logo_file');
            $name = $prefix . '_logo_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
            $f->move($targetDir, $name);
            $media['thumbnail'] = 'uploads/media/' . $name;
            $media['logo'] = 'uploads/media/' . $name;
        }

        // 2. Cover Banner file
        if ($request->hasFile('cover_file') && $request->file('cover_file')->isValid()) {
            $f = $request->file('cover_file');
            $name = $prefix . '_cover_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
            $f->move($targetDir, $name);
            $media['cover_image'] = 'uploads/media/' . $name;
        }

        // 3. Promo Video file
        if ($request->hasFile('video_file') && $request->file('video_file')->isValid()) {
            $f = $request->file('video_file');
            $name = $prefix . '_video_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
            $f->move($targetDir, $name);
            $media['video_url'] = 'uploads/media/' . $name;
        }

        // 4. Additional Gallery files
        if ($request->hasFile('gallery_files')) {
            $gFiles = $request->file('gallery_files');
            if (is_array($gFiles)) {
                foreach ($gFiles as $gf) {
                    if ($gf && $gf->isValid()) {
                        $name = $prefix . '_gallery_' . time() . '_' . Str::random(6) . '.' . $gf->getClientOriginalExtension();
                        $gf->move($targetDir, $name);
                        $media['gallery'][] = 'uploads/media/' . $name;
                    }
                }
            }
        }

        return $media;
    }
}

