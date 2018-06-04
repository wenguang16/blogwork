<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redis;
use DB;
use App\Http\Library\charset;
use Log;

class ArticleController extends Controller
{
    //
    public function index()
    {
        $redis = Redis::connection();
        print_r($redis);
        $file = fopen("/home/vagrant/code/blogwork/public/city.txt", "r");
        $user = array();
        $i = 0;
//输出文本中所有的行，直到文件结束为止。
        while (!feof($file)) {
            $cityArr = [];
            $user[$i] = fgets($file);//fgets()函数从文件指针中读取一行
            $arr = preg_split("/([a-zA-Z0-9]+)/", $user[$i], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            foreach ($arr as $k => $v) {
                $arr[$k] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $v);
               // $arr[$k] = preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $v, $chinese);
            }
            $user[$i] = $arr;
            $i++;
        }
        fclose($file);
        $user = array_filter($user);
        print_r($user);;die;
        foreach ($user as $k => $v) {
            $name = mb_substr($v[1],0,2,'utf-8');
            $sql = "select id,code from bc_region where name like '$name%'";
            $result = DB::select($sql);
            if(!empty($result)){
                if($result[0]->code !=$v[0]){
                    $this->update($result[0],$v[0]);
                }

            }
        }

print_r($user);die;
//        $charset=new charset();
////        foreach(array('武汉','中国','上海') as $val){
////            echo iconv('gbk','utf-8//IGNORE',strtoupper($charset->PinYin(mb_convert_encoding($val,'gbk','utf-8'))));
////            echo '<br/>';
////        }
////        die;
//       $result  = DB::select('select * from bc_region ORDER  by id desc limit 3000');
//        foreach ($result as $k => $v){
//
//            $shortName =  iconv('gbk','utf-8//IGNORE',strtoupper($charset->PinYin(mb_convert_encoding($v->name,'gbk','utf-8'))));
//
//            if(empty($v->shortname_en)){
//                $this->update($v,$shortName);
//            }
//
//        }


    }

    public function query($name){

    }
    public function update($data,$code){
        $res = DB::update("update bc_region set old_code = '$code' where id =$data->id");
        //print_r($shortName.'return'.$res);

    }

    public function test(){
        echo 'test';
    }
}


