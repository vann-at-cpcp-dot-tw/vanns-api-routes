<?php
namespace WPAPIRoutes\Controllers;

use WP_Query;
use WP_REST_Response;

class PostController {
  public function __construct() {
      // 在這裡可以初始化控制器
  }

  public function getPosts( $request ) {
    $query = $request->get_query_params();

    $args = [
      'post_type' => 'post',
      'posts_per_page' => 10,
    ];

    $wpQuery = new WP_Query($args);
    $posts = $wpQuery->get_posts();
    $requestList = [];

    if( empty($posts) ){
      $response = new WP_REST_Response(null, 204);
      return $response;
    }

    foreach ($posts as $post) {
        $requestList[] = [
            'title' => $post->post_title,
            'content' => $post->post_content,
            // 其他你需要的資料
        ];
    }

    $response = new WP_REST_Response([
      'message' => 'OK',
      'data'=> [
        'list', $requestList,
      ]
    ], 200);

    return $response;
  }
}
