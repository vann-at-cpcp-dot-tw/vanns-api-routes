<?php
namespace WPAPIRoutes\Controllers;

use WP_REST_Response;
use WPAPIRoutes\Models\PostModel;

class PostController {
  private $postModel;

  public function __construct(PostModel $postModel) {
    // 在這裡可以初始化控制器
    $this->postModel = $postModel;
  }

  public function getAll($request){

    $userQuery = $request->get_query_params();

    $result = $this->postModel->getAll($userQuery);

    if( empty($result['list']) ){
      $response = new WP_REST_Response(null, 204);
      return $response;
    }

    $response = new WP_REST_Response([
      'message' => 'OK',
      'data'=> [
        'list'=> $result['list'],
        'pagination'=> $result['pagination'],
      ]
    ], 200);

    return $response;
  }
}
