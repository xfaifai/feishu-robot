<?php

namespace Xfaifai\FeishuRobot\Support;

class RobotEncrypt
{
    /**
     * HmacSHA256 算法计算签名
     * @param string|null $time
     * @param string|null $secret
     * @return string
     */
    public static function makeSign(string $time = null, string $secret = null){
        $timestamp = $time ? $time : time();
        $string = "{$timestamp}\n{$secret}";
        return base64_encode(hash_hmac('sha256',"", $string,true));
    }
}