<?php

namespace Xfaifai\FeishuRobot;

/**
 * Author xfaifai
 * Class Robot
 * @package xfaifai
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
     * Notes: 发送卡片消息
     * @param string $msg_type
     * @param array $content
     * @return bool|mixed|string
     */
    public function sendInteractiveMsg(string $msg_type, array $content){
        try {
            if ($msg_type && $content) {
                return Request::send([
                    'url' => $this->notifyUrl,
                    'sign' => $this->signature
                ], $msg_type, $content);
            }
        } catch (\Throwable $e) {
            return false;
        }
    }
}

