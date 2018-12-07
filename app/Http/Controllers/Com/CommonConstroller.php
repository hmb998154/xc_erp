<?php
namespace App\Http\Controllers\Com;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Log;
use Storage;

/**
 * 公共接口
 */
class CommonConstroller extends Controller
{
    /**
     * 上传图片
     */
    public function webUpload(Request $req)
    {
        $res = $req->file('fileList');
        $name=$res[0]->getClientOriginalName();
        $ext=$res[0]->getClientOriginalExtension();
        $fileName=md5(uniqid($name));
        $fileName=$fileName.'.'.$ext;
        $bool= Storage::disk('article')->put($fileName,file_get_contents($res[0]->getRealPath()));
        $data['pic']='storage/Photo/article/'.$fileName;
        return _success($data);
    }

    /**
     * 送检配置类表
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function proCheck(Request $request)
    {
        switch ($request) {
            // 送检信息
            case 'check':
                return check();
                break;

            default:
            // 其他配置
                break;
        }
    }

}
