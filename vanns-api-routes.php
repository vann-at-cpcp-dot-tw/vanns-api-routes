<?php
/**
 * Plugin Name: Vann's API Routes
 * Description:
 */

require_once dirname(__FILE__) . '/autoload.php';
$routesPath = dirname(__FILE__) . '/routes/*.php';
$routesFiles = glob($routesPath);

add_action('rest_api_init', function() use ($routesFiles){
  foreach ($routesFiles as $file) {
    require_once $file;
  }
});