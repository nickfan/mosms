<?php
/**
 * Description
 *
 * @project mosms
 * @package 
 * @author nickfan<nickfan81@gmail.com>
 * @link http://www.axiong.me
 * @version $Id$
 * @lastmodified: 2015-02-04 14:28
 *
 */



namespace Nickfan\MoSms;


class MoClient {

    /**
     * 网关地址
     */
    var $url;

    /**
     * 用户名梦网科技提供
     */
    var $userid;

    /**
     * 密码,请通过梦网销售人员获取
     */
    var $password;

    /**
     * 子端口号码,默认为*
     */
    var $pszSubPort;

    /**
     * webservice客户端
     */
    var $soap;

    /**
     * 默认命名空间
     */
    var $namespace = 'http://sdkhttp.eucp.b2m.cn/';

    /**
     * 往外发送的内容的编码,默认为 GBK
     */
    var $outgoingEncoding = "GBK";

    /**
     * 往外发送的内容的编码,默认为 GBK
     */
    var $incomingEncoding = '';




    /**
     * @param string $url 			网关地址
     * @param string $userid 	用户名,请通过梦网销售人员获取
     * @param string $password		密码,请通过梦网销售人员获取

     * @param string $timeout		连接超时时间，默认0，为不超时
     * @param string $response_timeout		信息返回超时时间，默认30
     *
     *
     *
     * ($this->gwUrl,$this->userId,$this->password,$this->pszSubPort);
     */
    function __construct($url,$userid,$password,$pszSubPort)
    {
        $this->url = $url;
        $this->userid = $userid;
        $this->password = $password;
        $this->pszSubPort = $pszSubPort;



        /**
         * 初始化 webservice 客户端
         */
        $this->soap = new nusoap_client($url,false);
        $this->soap->soap_defencoding = $this->outgoingEncoding;
        $this->soap->decode_utf8 = false;


    }

    /**
     * 设置发送内容 的字符编码
     * @param string $outgoingEncoding 发送内容字符集编码
     */
    function setOutgoingEncoding($outgoingEncoding)
    {
        $this->outgoingEncoding =  $outgoingEncoding;
        $this->soap->soap_defencoding = $this->outgoingEncoding;

    }


    /**
     * 设置接收内容 的字符编码
     * @param string $incomingEncoding 接收内容字符集编码
     */
    function setIncomingEncoding($incomingEncoding)
    {
        $this->incomingEncoding =  $incomingEncoding;
        $this->soap->xml_encoding = $this->incomingEncoding;
    }



    function setNameSpace($ns)
    {
        $this->namespace = $ns;
    }

    //function getSessionKey()
    //{
    //	return $this->sessionKey;
    //}

    function getError()
    {
        return $this->soap->getError();
    }


    /**
     *
     * 指定一个 session key 并 进行登录操作
     *
     * @param string $sessionKey 指定一个session key
     * @return int 操作结果状态码
     *
     * 代码如:
     *
     * $sessionKey = $client->generateKey(); //产生随机6位数 session key
     *
     * if ($client->login($sessionKey)==0)
     * {
     * 	 //登录成功，并且做保存 $sessionKey 的操作，用于以后相关操作的使用
     * }else{
     * 	 //登录失败处理
     * }
     *
     *
     */
    /*	function login($sessionKey='')
        {
            if ($sessionKey!='')
            {
                $this->sessionKey = $sessionKey;
            }

            $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey, 'arg2'=>$this->password);

            $result = $this->soap->call("registEx",$params,	$this->namespace);


            return $result;
        }
        */

    /**
     * 注销操作  (注:此方法必须为已登录状态下方可操作)
     *
     * @return int 操作结果状态码
     *
     * 之前保存的sessionKey将被作废
     * 如需要，可重新login
     */
    /*	function logout()
        {
            $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
            print_r($params);
            $result = $this->soap->call("logout", $params ,
                $this->namespace
            );

            return $result;
        }
    */
    /**
     * 获取版本信息
     * @return string 版本信息
     */
    /*	function getVersion()
        {
            $result = $this->soap->call("getVersion",
                array(),
                $this->namespace
            );
            return $result;
        }
        */


    /**
     * 短信发送  (注:此方法必须为已登录状态下方可操作)
     *
     * @param array $mobiles		手机号, 如 array('159xxxxxxxx'),如果需要多个手机号群发,如 array('159xxxxxxxx','159xxxxxxx2')
     * @param string $content		短信内容
     * @param string $sendTime		定时发送时间，格式为 yyyymmddHHiiss, 即为 年年年年月月日日时时分分秒秒,例如:20090504111010 代表2009年5月4日 11时10分10秒
     * 								如果不需要定时发送，请为'' (默认)
     *
     * @param string $addSerial 	扩展号, 默认为 ''
     * @param string $charset 		内容字符集, 默认GBK
     * @param int $priority 		优先级, 默认5
     * @param int $priority 		信息序列ID(唯一的正整数)
     * @return int 操作结果状态码
     */
    function sendSMS($mobiles=array(),$content)
    {
        $mob ="";
        $cnt = count($mobiles);
        foreach($mobiles as $mobile)
        {
            $mob = $mob.$mobile.",";
            //print_r($mobile."<br/>");
        }
        $mob = substr($mob,0,strlen($mob)-1);

        if(!empty($mobiles) and !empty($content))
        {
            $params = array ('userId'=>$this->userid,
                'password'=>$this->password,
                'pszMsg' => $content,
                'iMobiCount'=>$cnt,
                'pszSubPort'=>$this->pszSubPort,
                'pszMobis'=>$mob
            );

            //$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,'arg2'=>$sendTime,
            //	'arg4'=>$content,'arg5'=>$addSerial, 'arg6'=>$charset,'arg7'=>$priority,'arg8'=>$smsId
            //	);

            /**
             * 多个号码发送的xml内容格式是
             * <arg3>159xxxxxxxx</arg3>
             * <arg3>159xxxxxxx2</arg3>
             * ....
             * 所以需要下面的单独处理
             *
             */
            //foreach($mobiles as $mobile)
            //{
            //	array_push($params,new soapval("pszMsg",false,$mobile));
            //}
            $result = $this->soap->call("MongateCsSpSendSmsNew",$params);
            return $result;
        }
    }


    /**
     * 余额查询  (注:此方法必须为已登录状态下方可操作)
     * @return double 余额
     */
    function getBalance()
    {
        $params = array('userId'=>$this->userid,'password'=>$this->password);

        $result = $this->soap->call("MongateQueryBalance",$params);
        return $result;

    }

    /**
     * 取消短信转发  (注:此方法必须为已登录状态下方可操作)
     * @return int 操作结果状态码
     * 废弃
     */
    /*	function cancelMOForward()
        {
            $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
            $result = $this->soap->call("cancelMOForward",$params,$this->namespace);
            return $result;
        }
    */
    /**
     * 短信充值  (注:此方法必须为已登录状态下方可操作)
     * @param string $cardId [充值卡卡号]
     * @param string $cardPass [密码]
     * @return int 操作结果状态码
     * 废弃
     * 请通过亿美销售人员获取 [充值卡卡号]长度为20内 [密码]长度为6
     */
    /*function chargeUp($cardId, $cardPass)
    {
        $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,'arg2'=>$cardId,'arg3'=>$cardPass);
        $result = $this->soap->call("chargeUp",$params,$this->namespace);
        return $result;
    }*/


    /**
     * 查询单条费用  (注:此方法必须为已登录状态下方可操作)
     * @return double 单条费用
     * 废弃
     */
    /*function getEachFee()
    {
        $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
        $result = $this->soap->call("getEachFee",$params,$this->namespace);
        return $result;
    }*/


    /**
     * 得到上行短信  (注:此方法必须为已登录状态下方可操作)
     *
     * @return array 上行短信列表, 每个元素是Mo对象, Mo对象内容参考最下面
     *
     *
     * 如:
     *
     * $moResult = $client->getMO();
     * echo "返回数量:".count($moResult);
     * foreach($moResult as $mo)
     * {
     * 	  //$mo 是位于 Client.php 里的 Mo 对象
     * 	  echo "发送者附加码:".$mo->getAddSerial();
     *	  echo "接收者附加码:".$mo->getAddSerialRev();
     *	  echo "通道号:".$mo->getChannelnumber();
     *	  echo "手机号:".$mo->getMobileNumber();
     * 	  echo "发送时间:".$mo->getSentTime();
     *	  echo "短信内容:".$mo->getSmsContent();
     * }
     *
     *
     */

    /**
     * 得到上行短信状态报告  (注:此方法必须为已登录状态下方可操作)
     *
     * @return array 状态报告列表, 每个元素是StatusReport对象, StatusReport对象内容参考最下面
     *
     *
     * 如:
     *
     * $reportResult = $client->getReport();
     * echo "返回数量:".count($reportResult);
     * foreach($reportResult as $report)
     * {
    //获取状态报告的信息
     * }
     *
     *
     */
    function getMO()
    {
        $res = array();
        $ret = array();
        $params = array('userId'=>$this->userid,'password'=>$this->password);
        $result = $this->soap->call("MongateCsGetSmsExEx",$params);
        //print_r($this->soap->response);
        //print_r($result);
        //$result = Array ( "String" => Array ( '0' => '2014-07-14,10:30:50,13912908627,10657120790700003041,*,1027226945'
//) );

        if (is_array($result) && count($result)>0)
        {
            /*	if (is_array($result[0]))
                {
                    foreach($result as $moArray)
                        $ret[] = new Mo($moArray);
                }else{
                    $ret[] = new Mo($result);
                }*/

            if (is_array($result['string']))
            {
                foreach($result as $moArray)
                    foreach ($moArray as $key){
                        $res = explode(",",$key);
                        $ret[] = new MoEntity($res);
                    }
            }else{
                $res = explode(",",$result['string']);
                $ret[] = new MoEntity($res);
            }
        }
        return $ret;
    }

    /**
     * 得到状态报告  (注:此方法必须为已登录状态下方可操作)
     * @return array 状态报告列表, 一次最多取5个
     * 没用到！
     */
    function getReport()
    {
        $params = array('userId'=>$this->userid,'password'=>$this->password);
        $result = $this->soap->call("MongateCsGetStatusReportExEx",$params);
        return $result;
    }




    /**
     * 企业注册  [邮政编码]长度为6 其它参数长度为20以内
     *
     * @param string $eName 	企业名称
     * @param string $linkMan 	联系人姓名
     * @param string $phoneNum 	联系电话
     * @param string $mobile 	联系手机号码
     * @param string $email 	联系电子邮件
     * @param string $fax 		传真号码
     * @param string $address 	联系地址
     * @param string $postcode  邮政编码
     *
     * @return int 操作结果状态码
     * 废弃
     */
    /*function registDetailInfo($eName,$linkMan,$phoneNum,$mobile,$email,$fax,$address,$postcode)
    {

        $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,
            'arg2'=>$eName,'arg3'=>$linkMan,'arg4'=>$phoneNum,
            'arg5'=>$mobile,'arg6'=>$email,'arg7'=>$fax,'arg8'=>$address,'arg9'=>$postcode
        );

        $result = $this->soap->call("registDetailInfo",$params,$this->namespace);
        return $result;

    }

   */

    /**
     * 修改密码  (注:此方法必须为已登录状态下方可操作)
     * @param string $newPassword 新密码
     * @return int 操作结果状态码
     * 废弃
     */
    /*	function updatePassword($newPassword)
        {

            $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,
             'arg2'=>$this->password,'arg3'=>$newPassword
         );

         $result = $this->soap->call("serialPwdUpd",$params,$this->namespace);
         return $result;

        }
        */
    /**
     *
     * 短信转发
     * @param string $forwardMobile 转发的手机号码
     * @return int 操作结果状态码
     * 废弃
     *
     */
    /*function setMOForward($forwardMobile)
    {

        $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,
         'arg2'=>$forwardMobile
     );

     $result = $this->soap->call("setMOForward",$params,$this->namespace);
     return $result;
    }
    */
    /**
     * 短信转发扩展
     * @param array $forwardMobiles 转发的手机号码列表, 如 array('159xxxxxxxx','159xxxxxxxx');
     * @return int 操作结果状态码
     * 废弃
     */
    /*function setMOForwardEx($forwardMobiles=array())
    {

     $params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);

     foreach($forwardMobiles as $mobile)
     {
         array_push($params,new soapval("arg2",false,$mobile));
     }

     $result = $this->soap->call("setMOForwardEx",$params,$this->namespace);
     return $result;


    }
*/

    /**
     * 生成6位随机数
     */
    /*	function generateKey()
        {
            return rand(100000,999999);
        }
        */

}