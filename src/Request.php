<?php

namespace Xfaifai\FeishuRobot\FeishuRobot;

/**
 * Author xfaifai
 * Class Request
 * @package xfaifai
 */
class Request {
    /**
     * Notes: 执行发送
     * @param array $config
     * @param string $msg_type
     * @param array $content
     * @return mixed
     */
    public static function send(array $config, string $msg_type, array $content){
        $timestamp = time();
        $data = json_encode([
            'timestamp' => $timestamp,
            'sign' => self::makeSign($timestamp, $config['sign']),
            'msg_type' => $msg_type,
            'card' => json_encode($content,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
        ],JSON_UNESCAPED_UNICODE);
        $header = ['Content-Type: application/json; charset=utf-8'];
        return self::doPost($config['url'], $data,100, $header);
    }


    /**
     * Notes: HmacSHA256 算法计算签名
     * @param string|null $time
     * @param string|null $secret
     * @return string
     */
    private static function makeSign(string|null $time = null, string|null $secret = null){
        $timestamp = $time ? $time : time();
        $string = "{$timestamp}\n{$secret}";
        return base64_encode(hash_hmac('sha256',"", $string,true));
    }

    /**
     * Notes: 发送post请求
     * @param string $url
     * @param string $data
     * @param int $timeout
     * @param array $header
     * @return bool|string
     */
    private static function doPost(string $url, string $data, int $timeout = 10, array $header = []){
        $curlObj = curl_init();
        $ssl = stripos($url,'https://') === 0 ? true : false;
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_AUTOREFERER => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)',
            CURLOPT_TIMEOUT => $timeout, //设置cURL允许执行的最长秒数
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
            CURLOPT_HTTPHEADER => ['Expect:'],
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
        ];
        if (!empty($header)) {
            $options[CURLOPT_HTTPHEADER] = $header;
        }

        if ($ssl) {
            //support https
            $options[CURLOPT_SSL_VERIFYHOST] = false;
            $options[CURLOPT_SSL_VERIFYPEER] = false;
        }
        curl_setopt_array($curlObj, $options);
        $returnData = curl_exec($curlObj);
        if (curl_errno($curlObj)) {
            //error message
            $returnData = curl_error($curlObj);
        }
        curl_close($curlObj);
        return $returnData;
    }
}

