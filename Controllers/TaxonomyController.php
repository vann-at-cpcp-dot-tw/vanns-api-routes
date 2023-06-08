<?php
namespace WPAPIRoutes\Controllers;

use WP_REST_Response;

class TaxonomyController {
  public function __construct() {
    // 在這裡可以初始化控制器
  }

  public function getAll($request){

    $query = $request->get_query_params();

    // format
    $list = get_taxonomies(array_merge([
      '_builtin'=> false,
    ], $query), 'objects');

    $list = array_map(function($key, $node){
      return [
        'name'=> $node->name,
        'label'=> $node->label,
        'description'=> $node->description,
      ];
    }, array_keys($list), array_values($list));

    $response = new WP_REST_Response([
      'message' => 'OK',
      'data'=> [
        'list'=> $list,
      ]
    ], 200);

    return $response;
  }

  public function getOne($request){
    $taxonomySlug = $request->get_param('taxonomySlug');
    $taxonomy = get_taxonomy($taxonomySlug);

    if( empty($taxonomy) ){
      $response = new WP_REST_Response(null, 204);
      return $response;
    }

    // format
    $taxonomy = [
      'name'=> $taxonomy->name,
      'label'=> $taxonomy->label,
      'description'=> $taxonomy->description,
    ];

    $terms = get_terms([
      'taxonomy'=>$taxonomy['name'],
      'hide_empty'=> false,
      'orderby'=> 'term_order',
    ]);

    $response = new WP_REST_Response([
      'message' => 'OK',
      'data'=> [
        'taxonomy'=> array_merge($taxonomy, [
          'terms'=> $terms
        ])
      ]
    ], 200);

    return $response;
  }
}
