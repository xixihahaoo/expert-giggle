<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends Controller {


    /**
     * @functionname: index
     * @author: FrankHong
     * @date: 2016-11-10 11:42:45
     * @description: 获取导航栏
     * @note:
     */
    public function navlist()
    {
       $navlist =  M('newsclass')->where('isshow=1 and fid in(1,3)')->select();
        foreach ($navlist as $k =>$v){
            $navlist[$k]['methodnm']=U($v['methodnm'],array('fid'=>$v['fid']));
        }

        return $navlist;
    }

    /**
     * 咨询主页面
     * @author: wang
     */
    public function index()
    {
        $nav  =  $this->navlist();  //循环分类
//         $arr = file_get_contents("http://m.jin10.com/flash?maxId=0");
//         $arr = json_decode($arr);
//
//         $page = 0;
//         $count = count($arr) / 10;
//         $arr = array_slice($arr,$page,10);  //分割数组
//
//        foreach ($arr as $key => $value) {
//
//                 $lista=explode("#", $value);
//
//                 $time=substr($lista[2], 11);
//
//                 if(strlen($time)<=8){
//
//                    $a[$key]['time']=$time;
//
//                    $a[$key]['content'] = preg_replace("/<img.+?\/>/", "", $lista[3]);
//
//                    $a[$key]['url']=$lista[4];
//                 }
//        }

        $rows = 20;
        $page = 1;
        $count = 2000 / $rows;

        $arr = file_get_contents("https://newsapi.eastmoney.com/kuaixun/v1/getlist_105__".$rows."_".$page."_.html");

        $arr = json_decode($arr,true);

        $a = [];
        foreach ($arr['LivesList'] as $key => $value) {

            $a[ $key ]['time']    = date('H:i:s',strtotime($value['showtime']));
            $a[ $key ]['content'] = $value['digest'];
            $a[ $key ]['url']     = $value['url_unique'];
        }

        $this->assign('nav',$nav);
        $this->assign('a',$a);
        $this->assign('count',ceil($count));
        $this->display();
    }

    /**
     * 咨询主页面 分页
     * @author: wang
     */
    public function new_nwes(){
          
//        $arr=file_get_contents("http://m.jin10.com/flash?maxId=0");
//
//        $arr=json_decode($arr);
//
//        $page = I('get.page') ? I('get.page') : 0;
//
//        $arr = array_slice($arr,$page,10);  //分割数组
//
//        foreach ($arr as $key => $value) {
//
//                 $lista=explode("#", $value);
//
//                 $time=substr($lista[2], 11);
//
//                 if(strlen($time)<=8){
//
//                    $a[$key]['time']=$time;
//
//                    //$a[$key]['content'] = str_replace("img","",$lista[3]);
//                    $a[$key]['content'] = preg_replace("/<img.+?\/>/", "", $lista[3]);
//
//                    $a[$key]['url']=$lista[4];
//                 }
//        }
//
//        $this->ajaxReturn($a,'JSON');

        $rows = 20;
        $page = empty(I('get.page')) ? 0 : trim(I('get.page'));
        $page = $page + 1;

        $arr = file_get_contents("https://newsapi.eastmoney.com/kuaixun/v1/getlist_105__".$rows."_".$page."_.html");

        $arr = json_decode($arr,true);

        $a = [];
        foreach ($arr['LivesList'] as $key => $value) {

            $a[ $key ]['time']    = date('H:i:s',strtotime($value['showtime']));
            $a[ $key ]['content'] = $value['digest'];
            $a[ $key ]['url']     = $value['url_unique'];
        }

        $this->ajaxReturn($a,'JSON');
 
    }


    /**
     * 行业资讯
     * @author: wang
     */
    public function news()
    {
        $url        = "https://m.jin10.com/getNews?maxId=0&c=";
        $content    = file_get_contents($url);
        $content    = json_decode($content,true);
        $data       = $content['list'];

        $count = count($data);
        $maxId = $data[$count-1]['tid'];

        $this->assign('maxId',$maxId);
        $this->assign('newslist',$data);
        $this->assign('nav',$this->navlist());
        $this->display('news_normal');
    }
    
    /**
     * 行业资讯 分页
     * @author: wang
     */
    public function new_news(){

        $maxId      = I('get.maxId');
        $url        = "https://m.jin10.com/getNews?maxId={$maxId}&c=";
        $content    = file_get_contents($url);
        $content    = json_decode($content,true);
        $data['list'] = $content['list'];

        $count          = count($data['list']);
        $data['maxId']  = $data['list'][$count-1]['tid'];

        $this->ajaxReturn($data,'JSON');
           
    }

    /**
     * 行业资讯详情
     * @author: wang
     */
    public function ndetail()
    {
        $tid = I('get.tid');
        $url = "https://news.jin10.com/datas/details/{$tid}.json";
        $content = file_get_contents($url);
        $content = json_decode($content,true);
        $data = $content;

        $data['text'] = html_entity_decode($data['text']);
        
        $this->assign('new',$data);
        $this->display();
    }

    /**
     * @functionname: analyse
     * @author: FrankHong
     * @date: 2016-11-10 11:43:02
     * @description: 行情分析页面
     * @note:
     */
    public function analyse()
    { $nav  =  $this->navlist();
        $this->assign('nav',$nav);
        $this->display();
    }
    /**
     * @functionname: news
     * @author: FrankHong
     * @date: 2016-11-10 11:44:01
     * @description: 获取类型文章
     * @note:
     */

    public function newsinfo($type=1)
        
    { $tq=C('DB_PREFIX');
        $news = D('newsinfo');
       return  $news->join($tq.'newsclass on '.$tq.'newsinfo.ncategory='.$tq.'newsclass.fid')->where($tq.'newsinfo.ncategory='.$type)->order($tq.'newsinfo.nid desc')->select();
    }


}