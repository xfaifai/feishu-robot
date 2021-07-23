<?php


namespace Xfaifai\FeishuRobot\Support;

/**
 * Author xfaifai
 * Class AccessToken
 * @package Xfaifai\FeishuRobot\Support
 */
class AccessToken
{
    private $config;
    private $url = 'https://open.feishu.cn/open-apis/auth/v3/tenant_access_token/internal/';

    public function __construct($config)
    {
        if (empty($config['app_id']) || empty($config['app_secret'])) {
            throw new \Exception('`app_id` or `app_secret` is empty');
        }
        $this->config = json_encode($config,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function getAccessToken() {
        return Request::doPost($this->url,$this->config,100,['Content-Type: application/json; charset=utf-8']);
    }
}