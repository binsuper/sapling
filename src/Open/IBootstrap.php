<?php

namespace Sapling\Open;

use Sapling\Plugin\Context;

/**
 * 引导程序
 */
interface IBootstrap {

    /**
     * 开始执行
     * @param Context $ctx
     */
    public function run(Context $ctx);
}
