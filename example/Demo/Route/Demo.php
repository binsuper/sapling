<?php

namespace Plugin\Demo\Route;

use \Sapling\Plugin\{
    Request,
    Response
};

class Demo implements \Sapling\Open\IRoute {

    public static function instance(): \Sapling\Open\IRoute {
        return new static();
    }

    public function run(Request $req, Response $resp) {
        
    }

}
