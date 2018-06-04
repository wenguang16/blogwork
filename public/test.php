<?php
//查找到php安装位置
$phpcmd = exec("which php");
print_r($phpcmd);
// 输出结果  /usr/bin/php

$arr = array();
$ret = exec("/bin/ls -l", $arr);
print_r($ret);
print_r($arr);

















?>