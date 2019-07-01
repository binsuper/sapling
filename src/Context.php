<?php

namespace Sapling;

/**
 * 上下文
 */
class Context {

    /**
     * 事件列表
     * 数据格式：[event_name] => object(IEvent)
     * 
     * @var array 
     */
    private $__events = [];

    /**
     * 吸收插件注册的信息
     * 
     * @param \Sapling\Plugin\Context $plgctx 插件的上下文实例
     * @return $this
     */
    public function assimilate(Plugin\Context $plgctx) {
        foreach ($plgctx->getRegisteredEvent() as $evt_name => $evt) {
            $this->__events[$evt_name][] = $evt;
        }
    }

    /**
     * 触发事件
     * 
     * @param \Sapling\Event\Request $req
     * @param callable $callback
     */
    public function trigger(Event\Request $req, $callback) {
        $evt_name = $req->getEventName();
        if (!isset($this->__events[$evt_name])) {
            return;
        }
        foreach ($this->__events[$evt_name] as $evt) {
            $resp = new Event\Response($req->getEventName());
            $evt->trigger($req, $resp);
            call_user_func($callback, $resp);
        }
    }

}
