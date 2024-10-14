<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;


class ImageUpload {

    public static function uploadImage($request,$heigh = null,$width = null,$path = null,$oldImage= null){
        if(null != $oldImage){
            // dd($oldImage);
            $actualPath = str_replace('storage/', '', $oldImage);
            // dd($actualPath);
            Storage::disk('public')->delete($actualPath);
        }
        $imageName = Str::uuid().date('y-m-d').'.'.$request->extension();
        $pathImage = $path ? $path.'/'.$imageName : $imageName ;
        $image = Image::read($request->path());
        [$widthDefault, $heightDefault] = getimagesize($request);
        $width = $width ?? $widthDefault;
        $heigh = $heigh ?? $heightDefault;
        $image->resize($width , $heigh);

        // dd(asset('storage/'.$pathImage));
        Storage::disk('public')->put($pathImage,(string) $image->encode());
       return 'storage/'.$pathImage;
    }
}
