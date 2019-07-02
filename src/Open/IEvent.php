<?php

namespace Sapling\Open;

use \Sapling\Plugin\{
    Request,
    Response
};

interface IEvent {

    /**
     * 实例化当前对象
     * @return $this
     */
    public static function instance() : IEvent;

    /**
     * 获取事件名称
     * 系统调度器会根据该名称，决定是否触发事件
     * @return string
     */
    public function getName(): string;

    /**
     * 事件触发
     * @param Request $req 请求对象
     * @param Response $resp 响应对象
     */
    public function trigger(Request $req, Response $resp);
}
