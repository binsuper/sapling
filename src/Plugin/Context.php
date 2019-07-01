<?php

namespace Sapling\Plugin;

use Sapling\Except\{
    EventError,
    RedeclaredError
};
use \Sapling\Open\{
    IPlugin,
    IEvent
};

/**
 * 插件全局上下文
 */
class Context {

    /**
     * 插件的实例对象
     * 
     * @var IPlugin
     */
    private $__plugin;

    /**
     * 已注册的事件
     * 数据格式：[event.name] => object(IEvent)
     * 
     * @var array 
     */
    private $__events = [];

    public function __construct(IPlugin $plugin) {
        $this->__plugin = $plugin;
    }

    /**
     * 获取插件实例
     * 
     * @return \Sapling\Open\IPlugin
     */
    public function getPlugin(): IPlugin {
        return $this->__plugin;
    }

    /**
     * 事件注册
     * 
     * @param \Sapling\Open\IEvent $evt
     * @return $this
     * @throws RedeclaredError
     */
    public function registerEvent(IEvent $evt) {
        if (empty($evt->getName())) {
            throw new EventError("plugin's<{$this->getPlugin()->getName()}> event_name can not be null");
        }
        if (isset($this->__events[$evt->getName()])) {
            throw new RedeclaredError("plugin's<{$this->getPlugin()->getName()}> event<{$evt->getName()}> had been register, can't not declare again");
        }
        $this->__events[$evt->getName()] = $evt;
        return $this;
    }

    /**
     * 获取已注册的事件
     * 
     * @return array
     */
    public function getRegisteredEvent(): array {
        return $this->__events;
    }

}
