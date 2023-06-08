<?php
/**
 * Plugin Name: Vann's API Routes
 * Description:
 */

require_once dirname(__FILE__) . '/autoload.php';
$routesPath = dirname(__FILE__) . '/routes/*.php';
$routesFiles = glob($routesPath);
foreach ($routesFiles as $file) {
    require_once $file;
}