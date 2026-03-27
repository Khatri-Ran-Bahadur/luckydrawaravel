<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageUploader
{
    public static function upload($folder='images',$image)
    {
        try {
            if (!$image) {
                return null;
            }
            $image_name = Str::random(20).time() . '.' . $image->getClientOriginalExtension();
            // store in storage folder
            $image->storeAs($folder, $image_name, 'public');
            // return image name
            return $folder.'/'.$image_name;
        } catch (\Throwable $th) {
            return null;
        }
       
    }

    public static function delete($image)
    {
        try {
            if (Storage::exists('public/' . $image)) {
                Storage::delete('public/' . $image);
            }
        } catch (\Throwable $th) {
            return null;
        }
    }
}