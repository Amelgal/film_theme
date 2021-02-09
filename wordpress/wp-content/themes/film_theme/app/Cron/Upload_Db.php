<?php

namespace Cactus\Cron;

use Cactus\Core\Base_Cron;

class Upload_Db extends Base_Cron{

  protected $name = 'daily_event';

  public function init() {

    ini_set('max_execution_time', 600);

    $param = (require(DIR_PATH . 'config/genres_config.php'));

    for ($i = 1; $i <= 20; $i++) {
      $params = [
        'page'     => $i,
        'per_page' => 100,
      ];
      $url = add_query_arg($params, 'http://ec2-18-219-233-220.us-east-2.compute.amazonaws.com/wpr/wp-json/mw/v1/movies');
      $response = wp_remote_get($url);
      $data = (array)json_decode(wp_remote_retrieve_body($response));

      for ($pos = 0; $pos < 100; $pos++) {
        $stack = [];
        $body = (array) $data['result'][$pos];

        $title = $body['title'];
        $original_title = $body['original_title'];
        $poster_path = $body['poster_path'];
        $overview = $body['overview'];
        $release_date = $body['release_date'];
        $budget = $body['budget'];
        $revenue = $body['revenue'];
        $runtime = $body['runtime'];
        $countries = $body['production_countries'];
        $original_id = $body['original_id'];
        $genre = $body['genres'];

        $genre_arr = explode(", ", $body['genres']);
        foreach ($param as $ru => $eng) {
          foreach ($genre_arr as $num => $genr) {
            if ($genr == $ru) {
              array_push($stack, $eng);
            }
          }
        }

        $post_arr = [
          'post_title'   => $title,
          'post_content' => '<p>' . $overview . '</p>',
          'post_name'    => $original_title,
          'post_status'  => 'publish',
          'post_type'    => 'film',
          'meta_input'   => [
            'title'       => $title,
            'orig_title'  => $original_title,
            'poster_path' => $poster_path,
            'overview'    => $overview,
            'genre'       => $genre,
            'release'     => $release_date,
            'budget'      => $budget,
            'revenue'     => $revenue,
            'runtime'     => $runtime,
            'country'     => $countries,
            'original_id' => $original_id,
          ],
        ];

        $id = $this->get_ID_by_origin($original_id);

        if ($id) {
          $post_arr = array_merge($post_arr, ['ID' => $id]);
        }

        $post_id = wp_insert_post($post_arr, TRUE);
        wp_set_object_terms($post_id, $stack, "film_genre", FALSE);
      }
    }
  }

  private function get_ID_by_origin($original_id) {
    global $wpdb;
    return $wpdb->get_var("SELECT post_id FROM " . PREFIX . "postmeta WHERE meta_key ='original_id' AND meta_value = " . $original_id);
  }

}