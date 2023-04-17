<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use File;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetFile($fileName)
    {
        // periksa otorisasi user
        if (!Auth::check()) {
            abort(403);
        }

        $filePath = storage_path('app/files/images/ktp/' . $fileName);
        if (!File::exists($filePath)) {
            abort(404);
        }

        $fileContents = File::get($filePath);
        dd($fileContents);
        $response = Response::make($filePath, 200);
        // $response->header('Content-Type', mime_content_type($filePath));
        return $response;
    }
}
