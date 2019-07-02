<?php

namespace Plugin\Demo\Event;

use \Sapling\Plugin\{
    Request,
    Response
};

class Demo implements \Sapling\Open\IEvent {

    public static function instance(): \Sapling\Open\IEvent {
        return new static();
    }

    public function getName(): string {
        return 'demo';
    }

    public function trigger(Request $req, Response $resp) {
        $resp->setParam('num', rand(1, 100));
    }

}
