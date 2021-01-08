<?php
namespace Core;

class Cron {

  public function __construct() {
    // добавляет новую крон задачу
    add_action('admin_head', array($this,'film_cron'));
    // добавляем функцию к указанному хуку
    add_action('daily_event_',array($this,'save_bd') );
  }
  public function film_cron() {
    if (!wp_next_scheduled('daily_event_')) {
      wp_schedule_event(time(), 'daily', 'daily_event_');
    }
  }
  public function save_bd() {
    $stack = [];
    $param = (require(DIR_PATH . 'param/genres_config.php'));
    ini_set('max_execution_time', 600);

    for ($i = 1; $i <= 20; $i++) {
      $url = "http://ec2-18-219-233-220.us-east-2.compute.amazonaws.com/wpr/wp-json/mw/v1/movies?page=" . $i . "&per_page=100";
      // Создаём запрос
      $ch = curl_init();

      // Настройка запроса
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_URL, $url);

      // Отправляем запрос и получаем ответ
      $data = json_decode(curl_exec($ch));

      // Закрываем запрос
      curl_close($ch);
      //var_dump($data);
      $data = (array) $data;
      for ($pos = 0; $pos < 100; $pos++) {
        $stack = [];
        foreach ($data['result'][$pos] as $key => $item) {
          switch ($key) {
            case 'title':
              $title = $item;
              break;
            case 'original_title':
              $original_title = $item;
              break;
            case 'poster_path':
              $poster_path = $item;
              break;
            case 'overview':
              $overview = $item;
              break;
            case 'genres':
              $genre = $item;
              $genre_arr = explode(", ", $item);
              foreach ($param as $ru => $eng) {
                foreach ($genre_arr as $num => $genr) {
                  if ($genr == $ru) {
                    array_push($stack, $eng);
                  }
                }
              }
              break;
            case 'release_date':
              $release_date = $item;
              break;
            case 'budget':
              $budget = $item;
              break;
            case 'revenue':
              $revenue = $item;
              break;
            case 'runtime':
              $runtime = $item;
              break;
            case 'production_countries':
              $countries = $item;
              break;
            case 'original_id':
              $original_id = $item;
              break;
            default:
              echo 'Error' . $key;
              break;
          }
        }
        $update_post = get_page_by_title($title, '', 'film');
        if ($update_post == NULL) {
          $post_arr = [
            'post_title'   => $title,
            'post_content' => '<img src="' . $poster_path . '" alt="' . $original_title . '">' . '<p>' . $overview . '</p>',
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
          $post_id = wp_insert_post($post_arr, TRUE);
          wp_set_object_terms($post_id, $stack, "film_genre", FALSE);
        }
        else {
          $post_arr = [
            'ID'           => $update_post['ID'],
            'post_title'   => $title,
            'post_content' => '<img src="' . $poster_path . '" alt="' . $original_title . '">' . '<p>' . $overview . '</p>',
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
          $post_id = wp_insert_post($post_arr, TRUE);
          wp_set_object_terms($post_id, $stack, "film_genre", FALSE);
        }
      }
    }
  }
}