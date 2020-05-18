<?php

/**
 * 验证码校验
 * @author main@mainblog.cn
 * @copyright 2020
 * 
 */

//判断session是否开启
if (!isset($_SESSION)) {
    //启用超全局变量session
    session_start();
}


if (!empty($_POST['vcode'])) {
    $submit_vcode = $_POST['vcode'];
} else {
    result(502, "验证码请不要留空");
}


if (isset($_SESSION['my_vcode'])) {
    $real_vcode = $_SESSION['my_vcode'];
} else {
    result(500, "无效验证码，或已过期");
}

if ($submit_vcode == $real_vcode) {
    unset($_SESSION["my_vcode"]);
    result(200, "验证码正确");
} else {
    result(501, "验证码不正确");
}

//输出json返回信息
function result($code, $desc)
{
    unset($json);
    $json["code"] = $code;
    $json["desc"] = $desc;
    die(json_encode($json));
}
