<?php

namespace Sapling\Event;

class Request {

    /**
     * 事件名称
     * 
     * @var string 
     */
    protected $_evt_name = '';

    /**
     * 请求数据
     * 
     * @var array
     */
    protected $_data = [];

    public function __construct(string $evt_name, array $data = []) {
        $this->_evt_name = $evt_name;
        $this->_data = $data;
    }

    /**
     * 本次请求的事件名称
     */
    public function getEventName(): string {
        return $this->_evt_name;
    }

    /**
     * 获取所有参数
     * 
     * @return array
     */
    public function getParams(): array {
        return $this->_data;
    }

    /**
     * 获取指定键名的参数
     * 
     * @param string $key 键名
     * @return mixed
     */
    public function getParam(string $key, $default = null) {
        return $this->_data[$key] ?? $default;
    }

}
