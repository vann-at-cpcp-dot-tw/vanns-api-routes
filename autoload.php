<?php
spl_autoload_register(function($className){
  $namespace = 'MyAPIRoutes\\';

  if (strpos($className, $namespace) === 0) {
    $className = str_replace($namespace, '', $className);
    $classFile = dirname(__FILE__) . '/' . str_replace('\\', '/', $className) . '.php';

    if (file_exists($classFile)) {
      require_once $classFile;
    }
  }
});