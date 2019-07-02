<?php

namespace Plugin\Demo;

class Bootstrap implements \Sapling\Open\IBootstrap {

    public function run(\Sapling\Plugin\Context $ctx) {
        $ctx->registerEvent(new Event\Show());
    }

}
