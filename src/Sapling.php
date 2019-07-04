<?php

namespace Sapling;

use Sapling\Except\{
    RecognizableError,
    RedeclaredError
};
use Sapling\Open\{
    IPlugin
};
use Sapling\Plugin\Context as PluginContext;

/**
 * 控制中心
 * 应用程序内应保证该实例唯一
 * @author Gino Huang <binsuper@126.com>
 */
class Sapling {

    //插件接入的文件名
    const PLUGIN_JOINT_NAME = 'plugin.php';

    /**
     * 已识别的插件对象实例
     * 数据格式：[plugin_dir] => Object(plugin)
     * 
     * @var array
     */
    private $__plugins_joint = [];

    /**
     * 已装在的插件列表
     * 数据格式：[plugin_name] => Object(Plugin)
     * 
     * @var array
     */
    private $__plugins_loaded = [];

    /**
     * 插件的上下文对象实例
     * 数据格式：[plugin_name] => Object(PluginContext)
     * 
     * @var array
     */
    private $__plugins_context = [];

    /**
     * 全局上下文对象实例
     * 
     * @var Context
     */
    private $__context = null;

    public function __construct() {
        $this->__context = new Context();
    }

    /**
     * 识别插件信息
     * 
     * @param string $plugin_dir 插件目录
     * @return IPlugin 插件信息
     */
    public function recognizePlugin(string $plugin_dir): IPlugin {
        $joint_file = $plugin_dir . DIRECTORY_SEPARATOR . self::PLUGIN_JOINT_NAME; //插件接入文件
        if (!file_exists($joint_file)) { //文件不存在
            throw new RecognizableError("file<{$plugin_dir}> not found");
        }
        $joint_file = realpath($joint_file);
        if (!empty($this->__plugins_joint[$joint_file])) { //已识别
            return $this->__plugins_joint[$joint_file];
        }
        if (!is_readable($joint_file)) { //文件不可读
            throw new RecognizableError("file<{$plugin_dir}> unreadable");
        } else if (!is_file($joint_file)) { //文件不可读
            throw new RecognizableError("file<{$plugin_dir}> is not file");
        }
        $plugin = require_once($joint_file);
        if (!$plugin) {
            throw new RecognizableError("file<{$plugin_dir}> require failed");
        } else if (!($plugin instanceof IPlugin)) {
            throw new RecognizableError("plugin<{$plugin_dir}> must be instance of interface<Sapling\Open\IPlugin>");
        }
        $this->__plugins_joint[$joint_file] = $plugin;
        return $plugin;
    }

    /**
     * 装载插件
     * 
     * @param array $plugins_dir 插件数据; 格式：[ 插件根目录 ]
     * @return $this
     * @throws RedeclaredError
     */
    public function loadPlugins(array $plugins_dir) {
        foreach ($plugins_dir as $dir) {
            $plugin = $this->recognizePlugin($dir);
            if (isset($this->__plugins_loaded[$plugin->getName()])) {
                throw new RedeclaredError('plugin<' . $plugin->getName() . '> had been loaded before');
            }
            $this->__plugins_loaded[$plugin->getName()] = $plugin;
            //执行引导程序
            $plgctx = $this->__getPluginContext($plugin);
            $plugin->bootstrap($plgctx);
            //吸收插件注册的信息
            $this->__context->assimilate($plgctx);
        }
        return $this;
    }

    /**
     * 获取插件对象实例
     * 
     * @param string $plugin_name 插件名称
     * @return IPlugin 如果插件没有加载，则返回null
     */
    public function getPlugin(string $plugin_name) {
        return $this->__plugins_loaded[$plugin_name] ?? null;
    }

    /**
     * 获取插件实例的上下文实例
     * 
     * @param IPlugin $plugin
     * @return Context
     */
    private function __getPluginContext(IPlugin $plugin): PluginContext {
        if (empty($this->__plugins_context[$plugin->getName()])) {
            $this->__plugins_context[$plugin->getName()] = new PluginContext($plugin);
        }
        return $this->__plugins_context[$plugin->getName()];
    }

    /**
     * 获取全局上下文实例
     * 
     * @return Context
     */
    public function getContext(): Context {
        return $this->__context;
    }

    /**
     * 触发事件
     * 
     * @param \Sapling\Plugin\Request $req
     * @param callable $callback
     */
    public function trigger(Plugin\Request $req, $callback) {
        $this->getContext()->trigger($req, $callback);
    }

    /**
     * 路由分发
     * 
     * @param \Sapling\Plugin\Request $req
     * @return \Sapling\Plugin\Response
     * @throws Except\RouteError
     */
    public function dispatch(Plugin\Request $req): Plugin\Response {
        return $this->getContext()->dispatch($req);
    }

}
