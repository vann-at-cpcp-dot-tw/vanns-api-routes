<?php
namespace WPAPIRoutes\Controllers;

use WP_REST_Response;

class HelloController {
  public function __construct() {
    // 在這裡可以初始化控制器
  }


  public function helloWorld( $request ) {

    $requestWorld = $request->get_param('requestWorld');
    $query = $request->get_query_params();

    // 在這裡處理請求，執行相應的操作
    $response = new WP_REST_Response([
      'message' => 'OK',
      'data'=> [
        'message' => 'Hello, ' . $requestWorld . '!'
      ]
    ], 200);

    return $response;
  }
}
