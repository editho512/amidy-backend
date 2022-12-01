<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UploadService {

    public function __construct()
    {

    }

    public function uploadFile($file, string $destination_path): string{

        $newFileName = $this->generateUniqueFileName($file->getClientOriginalExtension());

        $file->move('uploads/'.$destination_path, $newFileName);

        return $newFileName;
    }

    public function generateUniqueFileName(string $file_extension): string {

        return Str::random(20) . date('YmdHis') . "." . $file_extension;
    }

    public function deleteFile(String $fileName, String $destination_path){

        File::delete(public_path($destination_path . "/" . $fileName));
    }


}

