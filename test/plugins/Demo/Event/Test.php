<?php

namespace Plugin\Demo\Event;

use \Sapling\Event\{
    Request,
    Response
};

class Test implements \Sapling\Open\IEvent {

    /**
     * 获取事件名称
     * 系统调度器会根据该名称，决定是否触发事件
     * @return string
     */
    public function getName(): string {
        return 'test';
    }

    /**
     * 事件触发
     * @param Request $req 请求对象
     * @param Response $resp 响应对象
     */
    public function trigger(Request $req, Response $resp) {
        $resp->bad('nonono');
    }

}
