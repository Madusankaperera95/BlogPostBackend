<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImagesTrait
{
    public function getImageUrl($path){
        return Storage::disk('s3')->temporaryUrl($path,now()->addMinutes(15));
       // return Storage::disk('s3')->url($path);
    }
}
