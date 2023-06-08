<?php
$postController = new WPAPIRoutes\Controllers\PostController();

register_rest_route('api/v1', '/posts', [
  'methods' => 'GET',
  'callback' => [$postController, 'getAll'],
  'permission_callback' => '__return_true',
]);