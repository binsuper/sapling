<?php

return (new class implements \Sapling\Open\IPlugin {

        public function getBasedir(): string {
            return __DIR__;
        }

        public function getBootstrap(): \Sapling\Open\IBootstrap {
            return new Plugin\Demo\Bootstrap();
        }

        public function getDescription(): string {
            return 'demo_description';
        }

        public function getName(): string {
            return 'demo_plugin';
        }
    });
