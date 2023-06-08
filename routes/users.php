<?php
$userController = new WPAPIRoutes\Controllers\UserController();

register_rest_route('api/v1', '/users', [
  'methods' => 'GET',
  'callback' => [$userController, 'getAll'],
  'permission_callback' => '__return_true',
]);
