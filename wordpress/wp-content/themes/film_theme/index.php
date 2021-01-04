<?php get_header(); ?>

    <main id="primary_page" class="site-main">
        <div class="posts">
            <?php
            do_shortcode('[slider numberposts = 3 post_type = film]');
            $url = "http://ec2-18-219-233-220.us-east-2.compute.amazonaws.com/wpr/wp-json/mw/v1/movies?page=20&per_page=100";
            // Создаём запрос
            $ch = curl_init();

            // Настройка запроса
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            // Отправляем запрос и получаем ответ
            $data = json_decode(curl_exec($ch));

            // Закрываем запрос
            curl_close($ch);
            //var_dump($data);
            $data = (array) $data;
            //var_dump($data);
            /*foreach ($data['result'][0] as $key=>$item){
              //var_dump($key);
              //var_dump($item);
              switch ($key){
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
                  $genre= $item;
                  break;
                case 'release_date':
                  $release_date= $item;
                  break;
                case 'budget':
                  $budget = $item;
                  break;
                case 'revenue':
                  $revenue= $item;
                  break;
                case 'runtime':
                  $runtime = $item;
                  break;
                case 'production_countries':
                  $countries= $item;
                  break;
                case 'original_id':
                  $original_id = $item;
                  break;
                default:
                  echo 'Error'.$key;
                  break;
              }
            }

            $post_arr = [
              'post_title'   => $title,
              'post_content' => '<img src="' . $poster_path . '" alt="' . $original_title . '">' . '<p>' . $overview . '</p>',
              'post_name'    => $original_title,
              'post_status'  => 'publish',
              'post_type'    => 'film',
              'meta_input'   => [
                'title'         => $title,
                'orig_title'    => $original_title,
                'poster_path'   => $poster_path,
                'overview'      => $overview,
                'genre'         => $genre,
                'release'       => $release_date,
                'budget'        => $budget,
                'revenue'       => $revenue,
                'runtime'       => $runtime,
                'country'       => $countries,
                'original_id'   => $original_id
              ],
            ];
            //var_dump($post_arr);
            //wp_insert_post($post_arr, true);
            //wp_set_object_terms(98, "comedy", "film_genre", FALSE);*/
            //var_dump(get_option( 'cron' ));
            ?>
        </div>

    </main><!-- #main -->
    <div class="delimer"></div>
<?php get_footer(); ?>

<?php
//
//		if ( have_posts() ) :
//			while ( have_posts() ) :
//				the_post();
//				get_template_part( 'template-parts/content', get_post_type() );
//            ?>
    <!--                <hr>-->
    <!--                <div class="clean"></div>-->
<?php //			endwhile;
//		else :
//			get_template_part( 'template-parts/content', 'none' );
//		endif;
//