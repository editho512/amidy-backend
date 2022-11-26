<?php

namespace App\Services;

use Illuminate\Support\Str;


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


}

