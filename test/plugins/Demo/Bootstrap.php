<?php

namespace Plugin\Demo;

/**
 * 引导程序
 */
class Bootstrap implements \Sapling\Open\IBootstrap {

    /**
     * 开始执行
     * @param \Sapling\Plugin\Context $ctx
     */
    public function run(\Sapling\Plugin\Context $ctx) {
        $ctx->registerEvent(new Event\Test());
    }

}
