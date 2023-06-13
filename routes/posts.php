<?php
$postModel = new WPAPIRoutes\Models\PostModel();
$postController = new WPAPIRoutes\Controllers\PostController($postModel);

register_rest_route('api/v1', '/posts', [
  'methods' => 'GET',
  'callback' => [$postController, 'getAll'],
  'permission_callback' => '__return_true',
]);
