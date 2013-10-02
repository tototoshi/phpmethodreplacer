<?php
namespace MethodReplacer;


class ClassManager {

    private static $instance = null;

    private $runkit_managed_classes = array();

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            $instance = new ClassManager();
            self::$instance = $instance;
            return $instance;
        } else {
            return self::$instance;
        }
    }

    public function getManagedClassOrNewOne($class_name)
    {
        if (isset($this->runkit_managed_classes[$class_name])) {
            return $this->runkit_managed_classes[$class_name];
        } else {
            return new MethodReplaceableClass($class_name);
        }
    }

    public function register($class_name, $method_name, $method_implementation)
    {
        $this->runkit_managed_classes[$class_name] =
            $this
                ->getManagedClassOrNewOne($class_name)
                ->addMethod($method_name, $method_implementation);
    }

    public function deregister($class_name, $method_name)
    {
        $this
            ->getManagedClassOrNewOne($class_name)
            ->removeMethod($method_name);
    }

}

