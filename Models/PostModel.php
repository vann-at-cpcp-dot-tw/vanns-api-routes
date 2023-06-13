<?php
namespace WPAPIRoutes\Models;

use WP_Query;

class PostModel {
  public function getAll($userQuery=[]){

    define('DEFAULT_QUERY_ARGS', [
      'post_type' => 'post',
      'posts_per_page' => 10,
      'paged'=> 1,
    ]);

    define('ALLOW_QUERY_KEYS', [
      'post_type',
      'posts_per_page',
      'paged',
    ]);

    $userQuery = array_filter($userQuery, function($queryKey){
      return  in_array($queryKey, ALLOW_QUERY_KEYS);
    }, ARRAY_FILTER_USE_KEY);

    $wpQueryArgs = array_merge(DEFAULT_QUERY_ARGS, $userQuery);

    $wpQueryResult = new WP_Query($wpQueryArgs);

    $posts = $wpQueryResult->get_posts();

    $pagination = [
      'total_items' => $wpQueryResult->found_posts,
      'per_page'=> $wpQueryArgs['posts_per_page'],
      'total_page'=> ceil($wpQueryResult->found_posts / $wpQueryArgs['posts_per_page']),
      'current_page'=> $wpQueryArgs['paged'],
    ];

    $list = array_map(function($post) {
      $postID = $post->ID;
      $authorID = $post->post_author;
      return [
          'ID' => $postID,
          'title' => $post->post_title,
          'content' => $post->post_content,
          'excerpt' => $post->post_excerpt,
          'slug' => $post->post_name,
          'date' => $post->post_date,
          'categories' => array_filter(get_categories($postID), function($node) {
              return $node->slug !== 'uncategorized';
          }),
          'author' => [
              'ID' => $authorID,
              'departments' => get_terms([
                  'taxonomy' => 'departments',
                  'object_ids' => [$authorID],
                  'orderby' => 'term_order',
              ]),
              'nickname' => get_user_meta($authorID, 'nickname', true),
              'email' => get_the_author_meta('user_email', $authorID),
              'gravatar' => get_avatar_url($authorID),
          ],
      ];
    }, $posts);

    return [
      'list'=> $list,
      'pagination'=> $pagination,
    ];

  }
}