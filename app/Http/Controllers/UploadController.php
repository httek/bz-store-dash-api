<?php

namespace App\Http\Controllers;

use App\Http\Endpoints\Controller;
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
        $uploadedFiles = $request->file('file');
        $path = join('/', ['n4', md5($uploadedFiles->getBasename()) . '.' . $uploadedFiles->extension()]);
        if (! $disk->put($path, $uploadedFiles->getContent())) {
            return fail('Uploaded fail.');
        }

        return success(
            $disk->downloadUrl($path, 'https')
        );
    }
}
