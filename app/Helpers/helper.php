<?php

use Illuminate\Support\Str;

function uploadFile($file, $folder)
{
    $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
    $path = public_path("uploads/$folder");

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    $file->move($path, $filename);

    return $filename;
}