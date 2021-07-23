<?php

namespace Xfaifai\FeishuRobot\Server;

use Xfaifai\FeishuRobot\Support\RobotEncrypt;
use Xfaifai\FeishuRobot\Support\Request;

/**
 * Author xfaifai
 * Class Robot
 * @package Xfaifai\FeishuRobot\Server
 */
class Robot {

    /**
     * @var string 机器人通知地址
     */
    private $notifyUrl;

    /**
     * @var string 签名字符
     */
    private $signature;

    /**
     * Robot constructor.
     * @param string $notifyUrl
     * @param string $signature
     * @throws \Exception
     */
    public function __construct($notifyUrl = '', $signature = '')
    {
        if (empty($notifyUrl) || empty($signature)) {
            throw new \Exception('`notifyUrl` or `signature` is empty');
        }
        $this->notifyUrl = $notifyUrl;
        $this->signature = $signature;
    }

    /**
     * 发送卡片消息
     * @param string $msgType
     * @param string $cardContent
     * @return bool|string
     */
    public function sendInteractiveMsg(string $msgType, string $cardContent)
    {
        if ($msgType && $cardContent) {
            $timestamp = time();
            $data = json_encode(
                [
                    'timestamp' => $timestamp,
                    'sign'      => RobotEncrypt::makeSign($timestamp, $this->signature),
                    'msg_type'  => $msgType,
                    'card'      => $cardContent
                ],
                JSON_UNESCAPED_UNICODE
            );
            $header = ['Content-Type: application/json; charset=utf-8'];
            return Request::doPost($this->notifyUrl, $data,100, $header);
        }
    }
}

