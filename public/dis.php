<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 17:52
 */
include_once 'charset.class.php';
header('Content-type: text/html;charset=utf-8');

$charset=new charset();
foreach(array('武汉','中国','上海') as $val){
    echo iconv('gbk','utf-8//IGNORE',strtoupper($charset->PinYin(mb_convert_encoding($val,'gbk','utf-8'))));
    echo '<br/>';
}