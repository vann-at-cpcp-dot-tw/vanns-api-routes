<?php
namespace WPAPIRoutes\Controllers;

use WP_Query;
use WP_REST_Response;

class PostController {
  public function __construct() {
    // 在這裡可以初始化控制器
  }

  public function getAll( $request ) {
    $query = $request->get_query_params();

    $args = [
      'post_type' => 'post',
      'posts_per_page' => 10,
    ];

    $wpQuery = new WP_Query(array_merge($args, $query));
    $posts = $wpQuery->get_posts();
    $list = [];

    if( empty($posts) ){
      $response = new WP_REST_Response(null, 204);
      return $response;
    }

    foreach ($posts as $post) {
        $postID = $post->ID;
        $authorID = $post->post_author;

        $list[] = [
            'ID'=> $postID,
            'title'=> $post->post_title,
            'content'=> $post->post_content,
            'excerpt'=> $post->post_excerpt,
            'slug'=> $post->post_name,
            'date'=> $post->post_date,
            'categories'=> array_filter(get_categories($postID), function($node){
              return $node->slug !== 'uncategorized';
            }),
            'author'=>[
              'ID'=> $authorID,
              'nickname'=> get_user_meta($authorID, 'nickname', true),
              'email'=> get_the_author_meta('user_email', $authorID),
              'gravatar'=> get_avatar_url($authorID),
            ],
        ];
    }

    $response = new WP_REST_Response([
      'message' => 'OK',
      'data'=> [
        'list'=> $list,
      ]
    ], 200);

    return $response;
  }
}
