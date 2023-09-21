<?php
header('content-type:application/json;charset=utf8');
header('access-control-allow-origin: 1xyyx.cn');

// 固定数组
$validCodes = ['123456', '11', '888888'];

// 检查请求方法是否为 POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    done('非法请求', false);
}

$jsonData = file_get_contents('php://input');
$objData = json_decode($jsonData, true);

if ($objData !== null && isset($objData['code'])) {
    $key = $objData['code'];

    // 检查验证码是否在有效数组中
    if (in_array($key, $validCodes)) {
        done('核验成功!', true, $validCodes);
    } else {
        done('校验验码失败，该核验码非有效核验码或者不存在!', false);
    }
} else {
    done('请求数据有误', false);
}

function done($msg, $isSuccess, $obj = null)
{
    http_response_code(200);
    $doneMsg = array(
        'success' => $isSuccess,
        'msg' => $msg,
        "obj" => $obj,
        "attributes" => null
    );
    exit(json_encode($doneMsg));
}
?>
