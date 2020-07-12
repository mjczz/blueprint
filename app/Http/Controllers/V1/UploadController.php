<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/7/11
 * Time: 12:01
 */

namespace App\Http\Controllers\V1;

use App\Models\EditorFiles;
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
        $data = [];

        foreach ($request->file() as $file) {
            $url = Storage::url($file->store('edit_file', 'admin'));
            $urls[] = $url;

            $data[] = [
                'path' => $url,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }


        EditorFiles::insert($data);

        return [
            "errno" => 0,
            "data"  => $urls,
        ];
    }

}
