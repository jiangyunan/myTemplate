<?php
/**
 * Created by PhpStorm.
 * User: jiang
 * Date: 17-5-22
 * Time: 下午3:07
 */
function ajaxReturn($data = [],$type='JSON') {
    if (!is_array($data)) {
        return;
    }
    $data = array_merge([
        'code' => 10000,
        'msg' => '',
        'currentTime' => time()
    ], $data);

    ksort($data);

    switch (strtoupper($type)){
        case 'JSON' :
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:application/json; charset=utf-8');
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $encode = mb_detect_encoding($data, array('ASCII','UTF-8','GB2312','GBK','BIG5'));
            if($encode!='UTF-8')
            {
                //$data = encodeConvert($data,$encode,'utf-8');
                $data = iconv($encode,'utf-8',$data);
            }


            exit(trim($data,chr(239).chr(187).chr(191)));
        case 'JSONP':
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:application/json; charset=utf-8');
            $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
            exit($handler.'('.json_encode($data, JSON_UNESCAPED_UNICODE).');');
    }
}