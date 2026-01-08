<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

if (!function_exists('storeImage')) {
    /**
     * Store uploaded image with a standardized filename.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @param string|null $prefix
     * @return string Stored relative path (e.g. "about/20260108_name_xxx.jpg")
     */
    function storeImage($file, $folder = 'uploads', $disk = 'public', $prefix = null)
    {
        if (!$file) return null;

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();

        $slug = Str::slug(substr($originalName, 0, 64));
        $random = Str::random(6);
        $time = time();

        $parts = [];
        if ($prefix) $parts[] = $prefix;
        $parts[] = $time;
        if ($slug) $parts[] = $slug;
        $parts[] = $random;

        $filename = implode('_', $parts) . '.' . $ext;

        $path = $file->storeAs($folder, $filename, $disk);

        return $path;
    }
}

if (!function_exists('deleteImage')) {
    /**
     * Delete image from disk if exists.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    function deleteImage($path, $disk = 'public')
    {
        if (!$path) return false;
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }
}
