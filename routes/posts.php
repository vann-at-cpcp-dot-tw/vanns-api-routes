<?php
use WPAPIRoutes\Controllers\PostController;

add_action('rest_api_init', function(){

  $postController = new PostController();

  register_rest_route('api/v1', '/posts', [
    'methods' => 'GET',
    'callback' => [$postController, 'getAll'],
    'permission_callback' => '__return_true',
  ]);

});