<?php
/**
 * Description
 *
 * @project mosms
 * @package 
 * @author nickfan<nickfan81@gmail.com>
 * @link http://www.axiong.me
 * @version $Id$
 * @lastmodified: 2015-02-04 14:42
 *
 */



namespace Nickfan\MoSms;


class MoSms {

    var $gwUrl = 'http://sdk999ws.eucp.b2m.cn:8080/sdk/SDKService?wsdl';

    //var $serialNumber = '';
    var $userId = '';
    var $password = '';
    //子端口号码～默认为*
    var $pszSubPort = '*';
    //var $sessionKey = 'df311175c5040abf3f6d79d5203afeda';

    // var $connectTimeOut = 2;

    // var $readTimeOut = 10;

    // var $proxyhost = false;
    // var $proxyport = false;
    // var $proxyusername = false;
    // var $proxypassword = false;
    var $client;
    function client()
    {
        if(!$this->verifyCurSetup()){
            throw new \RuntimeException('gateway settings must be set!');
        }
        $this->client   = new MoClient($this->gwUrl,$this->userId,$this->password,$this->pszSubPort);
        return  $this->client ;
    }

    function __construct($settings=array()){
        return $this->init($settings);
    }
    function init($settings=array()){
        $settings+=array(
            'gwUrl'=>'',
            'userId'=>'',
            'password'=>'',
            'pszSubPort'=>'*',
        );
        !empty($settings['gwUrl']) && $this->gwUrl = $settings['gwUrl'];
        !empty($settings['userId']) && $this->userId = $settings['userId'];
        !empty($settings['password']) && $this->password = $settings['password'];
        !empty($settings['pszSubPort']) && $this->pszSubPort = $settings['pszSubPort'];
        return $this;
    }
    function verifyCurSetup(){
        if(empty($this->gwUrl)
            || empty($this->userId)
            || empty($this->password)
            || empty($this->pszSubPort)
        ){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 短信发送  (注:此方法必须为已登录状态下方可操作)
     *
     * @param array $mobiles        手机号, 如 array('159xxxxxxxx'),如果需要多个手机号群发,如 array('159xxxxxxxx','159xxxxxxx2')
     * @param string $content       短信内容
     * @param string $sendTime      定时发送时间，格式为 yyyymmddHHiiss, 即为 年年年年月月日日时时分分秒秒,例如:20090504111010 代表2009年5月4日 11时10分10秒
     *                              如果不需要定时发送，请为'' (默认)
     *
     * @param string $addSerial     扩展号, 默认为 ''
     * @param string $charset       内容字符集, 默认GBK
     * @param int $priority         优先级, 默认5
     * @param int $priority         信息序列ID(唯一的正整数)
     * @return int 操作结果状态码
     */
    function sendSMS($mobiles=array(),$content)
    {

        $client = $this->client();
        $client->setOutgoingEncoding("UTF-8");

        /**
         * 下面的代码将发送内容为 test 给 159xxxxxxxx 和 159xxxxxxxx
         * $client->sendSMS还有更多可用参数，请参考 Client.php
         */
        $statusCode = $client->sendSMS($mobiles,$content);
        return $statusCode ;


    }
    /**
     * 余额查询 用例
     */
    function getBalance()
    {
        $client = $this->client();
        $client->setOutgoingEncoding("UTF-8");

        $balance = $client->getBalance();
        return $balance;
    }


    /**
     * 接收状态
     */
    function getMO()
    {
        $client = $this->client();
        $client->setOutgoingEncoding("UTF-8");

        /**
         * $cardId [充值卡卡号]
         * $cardPass [密码]
         *
         * 请通过亿美销售人员获取 [充值卡卡号]长度为20内 [密码]长度为6
         *
         */

        $statusCode = $client->getMO();
        return   $statusCode;
    }


}