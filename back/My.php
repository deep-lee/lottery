<?php
/**
 * Created by PhpStorm.
 * User: Deep
 * Date: 15/12/10
 * Time: 上午1:21
 */

 function object_array($array) {
    if(is_object($array)) {
        $array = (array)$array;
     } if(is_array($array)) {
         foreach($array as $key=>$value) {
             $array[$key] = object_array($value);
             }
     }
     return $array;
}

//返回API执行结果（执行die输出）
function MySuccess($data, $code)
{
    $result = array("data"=>$data,"rt_code"=>(int)$code);
    //$result = json_encode($result);
    $result = MyJsonEncode($result);
    die($result);
}

function MySuccess3($data, $code)
{
    $encode_data = base64_encode(MyJsonEncode($data));
    $result = array("data"=>$encode_data,"rt_code"=>(int)$code);
    //$result = json_encode($result);
    $result = MyJsonEncode($result);
    die($result);
}

//返回API执行结果（执行die输出）
function MySuccess2($data, $code)
{
    $result = array("rt_data"=>$data,"rt_code"=>(int)$code);
    //$result = json_encode($result);
    $result = MyJsonEncode($result);
    die($result);
}

function MyError($type, $code){
    $result = array("type"=>$type,"rt_code"=>(int)$code);
    //$result = json_encode($result);
    $result = MyJsonEncode($result);
    die($result);
}

//数组转换保留为中文的JSON字符串
function MyJsonEncode($data){
    return urldecode(json_encode(MyUrlEncode($data)));
    //需要PHP版本5.4以上：
    //return json_encode($data,JSON_UNESCAPED_UNICODE);
}

//自定义的URL编码
function MyUrlEncode($data) {
    //可对关联数组进行URL编码，并处理换行符
    //内部递归调用
    //用于MyJsonEncode函数调用
    if(!is_array($data)){
        $data = str_replace("\r",'\r',$data);
        $data = str_replace("\n",'\n',$data);
        $data = urlencode($data);
    }
    else {
        foreach($data as $key=>$value) {
            $data[MyUrlEncode($key)] = MyUrlEncode($value);
            if((string)MyUrlEncode($key)!==(string)$key){
                unset($data[$key]);
            }
        }
    }
    return $data;
}
