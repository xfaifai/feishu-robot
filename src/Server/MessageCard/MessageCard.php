<?php

namespace Xfaifai\FeishuRobot\Server;

use Xfaifai\FeishuRobot\Support\Request;

/**
 * Author xfaifai
 * Class MessageCard
 * @package Xfaifai\FeishuRobot\Server
 */
class MessageCard {
    /**
     * 发送消息卡片
     * @param string $tenant_access_token
     * @param string $data
     * @return bool|string
     */
    public static function send(string $tenant_access_token, string $data)
    {
        $url = 'https://open.feishu.cn/open-apis/message/v4/send/';
        $header = ["Authorization: Bearer $tenant_access_token",'Content-Type: application/json; charset=utf-8'];
        return Request::doPost($url, $data, 100, $header);
    }

    /**
     * 更新消息卡片
     * @param string $tenant_access_token
     * @param string $data
     * @return bool|string
     */
    public static function update(string $tenant_access_token, string $data)
    {
        $url = 'https://open.feishu.cn/open-apis/interactive/v1/card/update';
        $header = ["Authorization: Bearer $tenant_access_token",'Content-Type: application/json; charset=utf-8'];
        return Request::doPost($url, $data, 100, $header);
    }
}

