<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class DownloadController extends Controller
{
    /**
     * 파일 다운로드
     * ['path'=>경로, 'name'=>이름]
     * @param Request $request
     * @return mixed
     */
    public function download(Request $request)
    {
        $storage = Storage::disk('public');
        if (!$storage->exists($request->path)) {
            return abort(404);
        }
        return $storage->download($request->path, $request->name);
    }
}
