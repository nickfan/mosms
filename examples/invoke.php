<?php
/**
 * Description
 *
 * @project mosms
 * @package 
 * @author nickfan<nickfan81@gmail.com>
 * @link http://www.axiong.me
 * @version $Id$
 * @lastmodified: 2015-02-04 15:01
 *
 */


require_once(__DIR__.'../vendor/autoload.php');

$mosmsInst = new \Nickfan\MoSms\MoSms(array(
    'gwUrl'=>'http://61.145.229.29:7903/MWGate/wmgw.asmx?wsdl',
    'userId'=>'',
    'password'=>'',
    'pszSubPort'=>'*',
));

$mobDict = array(
    '13012345678',
);
$content = '测试内容1';

$statsCode = $mosmsInst->sendSMS($mobDict,$content);
var_dump($statsCode);

$result = $mosmsInst->getMO();
if(!empty($result) and is_array($result)) {
	foreach($result as $k => $val)
	{
		echo $val->mobileNumber.PHP_EOL;
	}
}
