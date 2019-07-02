<?php

namespace Sapling\Plugin;

class Response {

    /**
     * 事件名称 | 路由名称
     * 
     * @var string 
     */
    protected $_exec_name = '';

    /**
     * 响应数据
     * 
     * @var array
     */
    protected $_data = [];

    /**
     * 响应结果, true为正常(默认)
     * 
     * @var bool
     */
    protected $_result = true;

    /**
     * 响应消息
     * 
     * @var string
     */
    protected $_result_errmsg = '';

    public function __construct(string $exec_name) {
        $this->_exec_name = $exec_name;
    }

    /**
     * 本次请求的名称
     */
    public function getExecName(): string {
        return $this->_exec_name;
    }

    /**
     * 响应错误
     * 
     * @param string $errmsg
     * @return $this
     */
    public function bad(string $errmsg = '') {
        $this->_result = false;
        $this->_result_errmsg = $errmsg;
        return $this;
    }

    /**
     * 是否响应正确
     * 
     * @return bool
     */
    public function isOk(): bool {
        return $this->_result;
    }

    /**
     * 错误详细
     * 
     * @return string
     */
    public function error(): string {
        return $this->_result_errmsg;
    }

    /**
     * 设置返回参数
     * 
     * @param string $key 键名
     * @param mixed $val 键值
     * @return $this
     */
    public function setParam(string $key, $val) {
        $this->_data[$key] = $val;
        return $this;
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
