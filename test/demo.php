<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

$plugin_demo_dir = __DIR__ . '/plugins/Demo';

$sapling = new \Sapling\Sapling();

$sapling->loadPlugins([$plugin_demo_dir]);

$req = new \Sapling\Event\Request('test');

$sapling->getContext()->trigger($req, function(\Sapling\Event\Response $resp) {
    print_r('trigger: ');
    if($resp->isOk()){
        print_r("it's ok");
    }else{
        print_r("something woring: " . $resp->error());
    }
});
