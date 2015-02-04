<?php
/**
 * Description
 *
 * @project mosms
 * @package 
 * @author nickfan<nickfan81@gmail.com>
 * @link http://www.axiong.me
 * @version $Id$
 * @lastmodified: 2015-02-04 14:35
 *
 */



namespace Nickfan\MoSms;


class MoEntity {

    /**
     * 发送者附加码
     */
    var $addSerial;

    /**
     * 接收者附加码
     */
    var $addSerialRev;

    /**
     * 通道号
     */
    var $channelnumber;

    /**
     * 手机号
     */
    var $mobileNumber;

    /**
     * 发送时间
     */
    var $sentTime;

    /**
     * 短信内容
     */
    var $smsContent;

    function __construct(&$ret=array())
    {
        $this->addSerial = "";//$ret[addSerial];
        $this->addSerialRev = "";//$ret[addSerialRev];
        $this->channelnumber = $ret[3];
        $this->mobileNumber = $ret[2];
        $this->sentTime = $ret[0]." ".$ret[1];
        $this->smsContent = $ret[5];

    }

    function getAddSerial()
    {
        return $this->addSerial;
    }
    function getAddSerialRev()
    {
        return $this->addSerialRev;
    }
    function getChannelnumber()
    {
        return $this->channelnumber;
    }
    function getMobileNumber()
    {
        return $this->mobileNumber;
    }
    function getSentTime()
    {
        return $this->sentTime;
    }
    function getSmsContent()
    {
        return $this->smsContent;
    }



}