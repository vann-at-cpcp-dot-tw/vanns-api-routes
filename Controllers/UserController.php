<?php
namespace WPAPIRoutes\Controllers;

use WP_REST_Response;
use WP_User_Query;

class UserController {
  public function __construct() {
    // 在這裡可以初始化控制器
  }

  public function getAll( $request ) {

    $query = $request->get_query_params();
    $queryRole = $query['role'];

    $userQuery = new WP_User_Query([
        'role'=> $queryRole,
    ]);

    $list = $userQuery->get_results();

    // format
    $list = array_map(function($node){
        $userID = $node->ID;
        return [
            'ID'=> $userID,
            'nickname'=> get_user_meta($userID, 'nickname', true),
            'email'=> $node->user_email,
            'gravatar'=> get_avatar_url($userID), // 獲取 gravatar 頭像，參數參考：https://developer.wordpress.org/reference/functions/get_avatar_url/
        ];
    }, $list);


    $response = new WP_REST_Response([
      'message' => 'OK',
      'data'=> [
        'list'=> $list,
      ]
    ], 200);

    return $response;
  }
}
