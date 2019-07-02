<?php

namespace Sapling\Open;

use Sapling\Plugin\{
    Request,
    Response
};

/**
 * 路由标准接口
 */
interface IRoute {

    /**
     * 实例化当前对象
     * @return $this
     */
    public static function instance(): IRoute;

    /**
     * 执行动作
     * @param Request $req 请求对象
     * @param Response $resp 响应对象
     */
    public function run(Request $req, Response $resp);
}
