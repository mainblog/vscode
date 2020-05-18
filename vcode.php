<?php

/**
 * 使用GD库随机生成一个验证码函数
 * @param $m:验证码的个数(默认为4个)
 * @param $type:验证码的类型(0;纯数字,1:数字+小写字母,2:数字+大小写字符)
 * @author main@mainblog.cn
 * @copyright 2020
 * 
 */

//判断session是否开启
if (!isset($_SESSION)) {
    //启用超全局变量session
    session_start();
}

//绘制验证码
$num = 4;  //验证码的长度
$str = getCode($num, 0); //使用下面的自定义函数,获取需要的验证码值,0为纯数字类型
$_SESSION['my_vcode'] = $str;
// echo mb_detect_encoding($str_encode); shuchu 
// 1.创建一个画布、分配颜色
$width = $num * 20; //宽度=字符数*20
$height = 30; //高度
$img = imagecreatetruecolor($width, $height); //创建一个真彩画布(指定大小)
$bg_color = imagecolorallocate($img, 230, 230, 230);  //背景颜色
$rand_color = imagecolorallocate($img, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));

// 2.开始绘画
//填充背景颜色
imagefill($img, 0, 0, $bg_color);
//添加边框
// imagerectangle($img, 0, 0, $width - 1, $height - 1, $rand_color);


//随机添加干扰点
for ($i = 0; $i < 200; $i++) {
    //随机干扰点颜色
    $disturb_color = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    imagesetpixel($img, mt_rand(0, $width), mt_rand(0, $height), $disturb_color);
}
//随机添加干扰线
for ($i = 0; $i < 5; $i++) {
    //随机干扰线颜色
    $line_color = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    imageline($img, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $line_color);
}

// 3.绘制验证码内容(一个一个字符绘制)
//引入字体相对路径
$font_face = './fonts/arialbd.ttf';
//为减少不必要的麻烦，字体路劲一定要使用绝对路径
//GD库加载字体文件时，需求提供绝对路径，路径用realpath()将相对路径转成绝对路径(目前测试PHP>7.0需要使用绝对路径)
$font_face = realpath($font_face);
// echo realpath($font_face);
for ($i = 0; $i < $num; $i++) {
    //随机字体颜色
    // 0-120 为深色,能更好的在浅色背景中识别验证码
    $font_color = imagecolorallocate($img, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
    $text = $str[$i];  //文本赋值
    //图形文本写入
    // imagettftext (画布资源,字体大小,倾斜角度,X轴位置,Y轴位置,字体颜色,字体路径,文字内容) 
    imagettftext($img, mt_rand(16, 18), mt_rand(-10, 10), 8 + (18 * $i), 24, $font_color, $font_face, $text);
}

// 4.输出图形
//设置响应头信息
//此函数执行前不可以有输出
header('Content-Type:image/png');
imagepng($img);

// 5.销毁图片(释放内容);
imagedestroy($img);
die();



function getCode($m = 4, $type = 0)
{
    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //t[0]:0-9:数字 ;t[2]:0-35：数字+小写字母 ;t[2]:0-末端：所有字符;
    $t = array(9, 35, strlen($str) - 1);
    // print_r($t); //打印数组
    //随机生成验证码所需内容
    $c = '';
    for ($i = 0; $i < $m; $i++) {
        $c .= $str[mt_rand(0, $t[$type])];
    }
    return $c;
    // echo strlen($str); //字符串长度
}
// echo getCode();