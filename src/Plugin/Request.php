<?php

namespace Sapling\Plugin;

class Request {

    /**
     * 事件名称 | 路由名称
     * 
     * @var string 
     */
    protected $_exec_name = '';

    /**
     * 请求数据
     * 
     * @var array
     */
    protected $_data = [];

    public function __construct(string $exec_name, array $data = []) {
        $this->_exec_name = $exec_name;
        $this->_data = $data;
    }

    /**
     * 本次请求的名称
     */
    public function getExecName(): string {
        return $this->_exec_name;
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
