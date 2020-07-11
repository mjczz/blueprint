<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/7/11
 * Time: 12:01
 */

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends ApiBaseController
{
    /**
     * 上传富文本编辑器图片
     *
     * @param Request $request
     *
     * @return array
     */
    public function uploadEditFile(Request $request)
    {
        $urls = [];

        foreach ($request->file() as $file) {
            $urls[] = Storage::url($file->store('edit_file', 'admin'));
        }

        return [
            "errno" => 0,
            "data"  => $urls,
        ];
    }

}
