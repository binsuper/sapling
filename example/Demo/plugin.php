<?php

namespace Plugin\Demo;

return (new class implements \Sapling\Open\IPlugin {

        /**
         * 获取插件的根目录
         * @return string 根目录的绝对路径
         */
        public function getBasedir(): string {
            return __DIR__;
        }

        /**
         * 获取插件的描述信息
         * @return string 返回插件的名称
         */
        public function getDescription(): string {
            return 'demo_description';
        }

        /**
         * 获取插件名称
         * 注意：插件名称是唯一的，如果与其它插件的名称相同，将无法正常接入
         * @return string 返回插件的名称
         */
        public function getName(): string {
            return 'Demo';
        }

        /**
         * 执行引导程序
         * 
         * @param Context $ctx
         * @return $this
         */
        public function bootstrap(\Sapling\Plugin\Context $ctx) {
            //事件
            $ctx->registerEvent(Event\Demo::class);

            //路由
            $ctx->registerRoute('demo', Route\Demo::class);

            return $this;
        }
    });
