<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utils\FileUploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * @param FileUploadRequest $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function upload(FileUploadRequest $request)
    {
        $disk = Storage::disk('7ox');
        $uploadedFile = $request->file('file');
        $path = join('/', ['n4', md5($uploadedFile->getBasename()) . '.' . $uploadedFile->extension()]);
        if (!$disk->put($path, $uploadedFile->getContent())) {
            return fail('Upload fail.');
        }

        return success($disk->downloadUrl($path, 'https'));
    }
}
