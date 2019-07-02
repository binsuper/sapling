<?php

namespace Sapling\Plugin;

use Sapling\Except\{
    EventError,
    RouteError,
    RedeclaredError
};
use \Sapling\Open\{
    IPlugin,
    IEvent,
    IRoute
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
     * 数据格式：[event.name] => string(IEvent_Class)
     * 
     * @var array 
     */
    private $__events = [];

    /**
     * 已注册的路由
     * 数据格式：[route.path] => string(IRoute_Class)
     * 
     * @var array 
     */
    private $__routes = [];

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
     * @param string $evt_class
     * @return $this
     * @throws EventError
     * @throws RedeclaredError
     */
    public function registerEvent(string $evt_class) {
        if (!class_exists($evt_class)) {
            throw new EventError("plugin's<{$this->getPlugin()->getName()}> event<{$evt_class}> not found");
        }
        $evt = $evt_class::instance();
        if (!($evt instanceof IEvent)) {
            throw new EventError("plugin's<{$this->getPlugin()->getName()}> event<{$evt_class}> must be subclass of IEvent");
        }
        if (empty($evt->getName())) {
            throw new EventError("plugin's<{$this->getPlugin()->getName()}> event_name can not be null");
        }
        if (isset($this->__events[$evt->getName()])) {
            throw new RedeclaredError("plugin's<{$this->getPlugin()->getName()}> event<{$evt->getName()}> had been register, can't not declare again");
        }
        $this->__events[$evt->getName()] = $evt_class;
        return $this;
    }

    /**
     * 获取已注册的事件
     * 
     * @return array
     */
    public function getRegisteredEvents(): array {
        return $this->__events;
    }

    /**
     * 路由注册
     * 
     * @param string $route_name
     * @param string $route_class
     * @return $this
     * @throws EventError
     * @throws RedeclaredError
     */
    public function registerRoute(string $route_name, string $route_class) {
        if (!class_exists($route_class)) {
            throw new EventError("plugin's<{$this->getPlugin()->getName()}> route<{$route_class}> not found");
        }
        $route = $route_class::instance();
        if (!($route instanceof IRoute)) {
            throw new RouteError("plugin's<{$this->getPlugin()->getName()}> route<{$route_class}> must be subclass of IRoute");
        }
        if (empty($route_name)) {
            throw new RouteError("plugin's<{$this->getPlugin()->getName()}> route_name can not be null");
        }
        if (isset($this->__routes[$route_name])) {
            throw new RedeclaredError("plugin's<{$this->getPlugin()->getName()}> route<{$route_name}> had been register, can't not declare again");
        }
        $this->__routes[$route_name] = $route_class;
        return $this;
    }

    /**
     * 获取已注册的路由
     * 
     * @return array
     */
    public function getRegisteredRoutes(): array {
        return $this->__routes;
    }

}
