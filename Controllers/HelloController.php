<?php
namespace MyAPIRoutes\Controllers;

use WP_REST_Response;

class HelloController {
  public function __construct() {
      // 在這裡可以初始化控制器
  }

  public function helloWorld( $request ) {

      $requestWorld = $request->get_param('requestWorld');
      $query = $request->get_query_params();

      // 在這裡處理請求，執行相應的操作
      $data = [
          'message' => 'Hello, ' . $requestWorld . '!'
      ];

      return rest_ensure_response($data);
  }
}
