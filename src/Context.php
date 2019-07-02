<?php

namespace Sapling;

/**
 * 上下文
 */
class Context {

    /**
     * 事件列表
     * 数据格式：[event_name] => string(IEvent_Class)
     * 
     * @var array 
     */
    private $__events = [];

    /**
     * 路由列表
     * 数据格式：[route_name] => string(IRoute_Class)
     * 
     * @var array 
     */
    private $__routes = [];

    /**
     * 吸收插件注册的信息
     * 
     * @param \Sapling\Plugin\Context $plgctx 插件的上下文实例
     * @return $this
     */
    public function assimilate(Plugin\Context $plgctx) {
        // 处理事件
        foreach ($plgctx->getRegisteredEvents() as $name => $class) {
            $this->__events[$name][] = $class;
        }
        // 处理路由
        foreach ($plgctx->getRegisteredRoutes() as $name => $class) {
            $full_name = $plgctx->getPlugin()->getName() . '/' . trim($name, '/');
            $this->__routes[$full_name] = $class;
        }
    }

    /**
     * 触发事件
     * 
     * @param \Sapling\Plugin\Request $req
     * @param callable $callback
     */
    public function trigger(Plugin\Request $req, $callback) {
        $evt_name = $req->getExecName();
        if (!isset($this->__events[$evt_name])) {
            return;
        }
        foreach ($this->__events[$evt_name] as $evt_class) {
            $evt = $evt_class::instance();
            $resp = new Plugin\Response($req->getExecName());
            $evt->trigger($req, $resp);
            call_user_func($callback, $resp);
        }
    }

    /**
     * 路由分发
     * 
     * @param \Sapling\Plugin\Request $req
     * @return \Sapling\Plugin\Response
     * @throws Except\RouteError
     */
    public function dispatch(Plugin\Request $req): Plugin\Response {
        $route_name = $req->getExecName();
        if (!isset($this->__routes[$route_name])) {
            throw new Except\RouteError("route<{$route_name}> not found");
        }
        $route_class = $this->__routes[$route_name];
        $resp = new Plugin\Response($req->getExecName());
        $obj = $route_class::instance();
        $obj->run($req, $resp);
        return $resp;
    }

}
