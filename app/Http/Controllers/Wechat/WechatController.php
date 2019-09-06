<?php

namespace App\Http\Controllers\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Members;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;
class WechatController extends Controller
{    
   
    private $token;
    private $appid;
    private $appsecret;
    public function __construct(){
        $website =new Website();
        $webconfig=$website::first();
        $this->token=$webconfig['wx_token'];
        $this->appid=$webconfig['wx_appid'];
        $this->appsecret=$webconfig['appsecret'];
    }

    public function index(Request $request){
        $data =$request->all();
        if(isset($data['echostr'])&& !empty($data['echostr'])){
            return $this->checkToken($request);
        }
    }
    //接入微信
    public function checkToken(Request $request){
        $token=$this->token;
        $data =$request->all();
        $signature = $data["signature"];
        $timestamp = $data['timestamp'];
        $nonce = $data['nonce'];  
        $echostr = $data['echostr'];  
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce
        );
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);        
        if ($tmpStr == $signature) {
            return $echostr;
        } else {
            return false;
        }
    }
    //回复
    public function getMessage(){               
        $from_xml = file_get_contents("php://input",'r');       
        if (empty($from_xml)) {
            return 1;
        }else{
            $ticket_xml = $from_xml;
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($ticket_xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $MsgType=trim($postObj->MsgType);//消息类型
            switch($MsgType){
                case "text":
                    $resultStr = $this->MsgTypeText($postObj);//文本
                    break;
                case "event":
                    $resultStr = $this->MsgTypeEvent($postObj);//事件
                    break;
                default:
                    $resultStr = "";
                    break;
            }
            echo $resultStr;
        }
    }
    //文本回复
    public function MsgTypeText($postObj){
        //获取关键词
        $keywords =trim($postObj->Content);
        if($keywords =="hello"){
            $msg ="你好，今天怎么样";
            $result=$this->sendText($postObj,$msg);
        }elseif($keywords =='news'){//获取新闻
            $msg=[
                    [
                        'title'=>'秋收季来临 全国各地奏响丰收的乐章',
                        'description'=>'新疆和硕，戈壁滩上辣椒火红大丰收。',
                        'picurl'=>'https://inews.gtimg.com/newsapp_bt/0/10167591664/1000',
                        'url'=>'https://3w.huanqiu.com/a/6a6d07/9CaKrnQhWyw?agt=8'
                    ],
                    [
                        'title'=>'“中美磋商计划是否有变”？中国外交部回应',
                        'description'=>'外交部发言人耿爽主持例行记者会，记者问：中美双方原计划9月初在华盛顿进行新一轮经贸磋商。',
                        'picurl'=>'https://inews.gtimg.com/newsapp_bt/0/10167111603/1000',
                        'url'=>'https://new.qq.com/omn/FIN20190/FIN2019090200828800.html'
                    ],
            ];
            $result=$this->sendNews($postObj,$msg);
        }else{
            $msg ="等待处理";
            $result=$this->sendText($postObj,$msg);
        }
        return $result;        
    }
    //发送文本
    public function sendText($postObj,$msg){
        $xml ="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
        $result=sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj->MsgType,$msg);
        return $result;
    }
    //发送图文消息
    public function sendNews($postObj,$msg){       
        $news_xml='<item>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>';
        $item ="";
        foreach($msg as $v){
            $item .=sprintf($news_xml,$v['title'],$v['description'],$v['picurl'],$v['url']);
        }
        $xml ='<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>%s</ArticleCount>
                <Articles>
                    %s
                </Articles>
                </xml>';           
        $result =sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),count($msg),$item);
        return $result;
    }
    //获取access_token
    public function access_token(){
        if(Cache::get("access_token")){
            $access_token= Cache::get("access_token");
        }else{
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
            $data =Curl::to($url)->get();
            $data=json_decode($data,true);
            $access_token=$data['access_token'];
            Cache::put('access_token',$access_token,7200);
        }        
        return $access_token;
    }
    //微信授权登录
    public function wx_login(Request $request){
        //回调地址     
        $from = $request->all();  
        if(!empty($from) && $from['code']){     
            $code=$from['code'];             
            $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appid}&secret={$this->appsecret}&code=$code&grant_type=authorization_code";
            $data=Curl::to($oauth2Url)->get();                
            $getInfo=json_decode($data,true);
            if(isset($getInfo['errcode'])){
                return $getInfo;
            }            
            $access_token = $getInfo['access_token'];
            $openid = $getInfo['openid'];  
            $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $data=Curl::to($get_user_info_url)->get();
            $user_info=json_decode($data,true);                        
            $info=$this->if_register($user_info);
            if(empty($info) || $info ==NULL){
                $this->add_wx($user_info);
            }
            return ['code'=>true];
        }else{           
            $redirect_uri = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);        
            $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appid}&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";
            header("Location:".$url);
            exit;            
            
        }  
    }
    //注册微信账户
    public function add_wx($user_info){       
        $members =new Members();
        $data=array(
            'wx_openid'=>$user_info['openid'],
            'wx_info'=>$user_info['nickname'],
            'wx_unionid'=>isset($user_info['unionid']) ? $user_info['unionid'] :"",
            'user_headimg'=>$user_info['headimgurl'],
            'sex'=>$user_info['sex'],
        );        
        $result=$members->create($data);
        return $result;
    }
    //检测微信用户是否注册
    public function if_register($user_info){
        $members =new Members();
        $data=$members::where('wx_openid',$user_info['openid'])->first();
        return $data;
    }
    //获取用户信息
    public function get_user_info($openid){
        $access_token=$this->access_token();
        $url ="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $user_info=Curl::to($url)->get();
        return json_decode($user_info,true);
    }
    //获取关注信息
    public function get_fans($next_openid){
        $access_token=$this->access_token();
        $url ="https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$next_openid";
        $user_info=Curl::to($url)->get();
        return json_decode($user_info,true);
    }
    public function MenuCreate ($jsonmenu){
        $access_token=$this->access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $result =Curl::to($url)->withData($jsonmenu)->post();
        return $result;
    }
//自定义菜单: 自定义菜单查询接口 /menu/get
    public function MenuGet (){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$this->access_token()}";
        return Curl::to($url)->get();
    }
//自定义菜单: 自定义菜单删除接口 /menu/delete
    public function MenuDelete (){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$this->access_token()}";
        return Curl::to($url)->get();
    }


}
