<?php
require_once dirname(__FILE__) . '/autoload.php';

use WPAPIRoutes\Controllers\HelloController;
use WPAPIRoutes\Controllers\PostsController;

add_action('rest_api_init', function(){

  $helloController = new HelloController();
  $postsController = new PostsController();

  register_rest_route('api/v1', '/hello/(?P<requestWorld>\w+)', [
    'methods' => 'GET',
    'callback' => [$helloController, 'helloWorld'],
    'permission_callback' => '__return_true' // 用於驗證使用者是否具有訪問該路由的權限。如果你希望將路由公開，可以使用 __return_true 函式作為 permission_callback 的值，這表示任何使用者都可以訪問該路由。
  ]);

  register_rest_route('api/v1', '/posts', [
    'methods' => 'GET',
    'callback' => [$postsController, 'getPosts'],
    'permission_callback' => '__return_true',
  ]);

});
