<?php

namespace Plugin\Demo\Event;

class Show implements \Sapling\Open\IEvent {

    public function getName(): string {
        return 'demo';
    }

    public function trigger(\Sapling\Event\Request $req, \Sapling\Event\Response $resp) {
        $resp->setParam('num', rand(1, 100));
    }

}
