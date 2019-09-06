<?php

function getTree($data, $pId,$level=0)
{
    static $tree =[];
    foreach($data as $k => $v)
    {
        if($v['pid'] == $pId)
        {      
               $v['level'] =$level;
               $tree[] = $v;              
               getTree($data, $v['act_id'],$level+1); 
               unset($data[$k]);
        }
    }
    return $tree;
}
/***********递归方式获取上下级权限信息****************/

function generateTree($arr,$id=0,$level=0)
{
    $list =array();
    foreach ($arr as $k=>$v){
        if ($v['pid'] == $id){
            $v['level']=$level;
            $v['son'] = generateTree($arr,$v['act_id'],$level+1);
            $list[] = $v;
        }
    }
    return $list;
}

function getTrees($data, $pId=0,$key='id',$pk='pid',$level=0)
{
    static $tree =[];
    foreach($data as $k => $v)
    {
        if($v[$pk] == $pId)
        {      
               $v['level'] =$level;
               $tree[] = $v;            
               getTrees($data,$v[$key],$key,$pk,$level+1); 
               unset($data[$k]);
        }
    }
    return $tree;
}
