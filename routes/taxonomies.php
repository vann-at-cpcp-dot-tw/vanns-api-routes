<?php
$taxonomyController = new WPAPIRoutes\Controllers\TaxonomyController();

register_rest_route('api/v1', '/taxonomies', [
  'methods' => 'GET',
  'callback' => [$taxonomyController, 'getAll'],
  'permission_callback' => '__return_true',
]);


register_rest_route('api/v1', '/taxonomies/(?P<taxonomySlug>\w+)', [
  'methods' => 'GET',
  'callback' => [$taxonomyController, 'getOne'],
  'permission_callback' => '__return_true'
]);
