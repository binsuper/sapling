<?php

namespace Sapling\Open;

/**
 * 插件接口定义
 * plugin接口定义了插件与系统对接的唯一标准
 */
interface IPlugin {

    /**
     * 获取插件的根目录
     * @return string 根目录的绝对路径
     */
    public function getBasedir(): string;

    /**
     * 获取插件名称
     * 注意：插件名称是唯一的，如果与其它插件的名称相同，将无法正常接入
     * @return string 返回插件的名称
     */
    public function getName(): string;

    /**
     * 获取插件的描述信息
     * @return string 返回插件的名称
     */
    public function getDescription(): string;

    /**
     * 获取引导程序的实例对象
     * @return IBootstrap 返回引导程序的实例对象
     */
    public function getBootstrap(): IBootstrap;
}
