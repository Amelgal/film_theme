<?php

namespace Cactus\Theme\Blocks;

use Cactus\Bootstrap\Bootstrap;
use WP_Post;

class News extends AbstractBlock {

	/**
	 * @var string
	 */
	protected $slug = 'news';

	/**
	 * @var string
	 */
	protected $title = 'News';

	/**
	 * @var string
	 */
	protected $icon = 'feedback';

	/**
	 * @var array
	 */
	protected $posts = [];

	/**
	 * @param WP_Post $post
	 */
	public function renderItem( \WP_Post $post ) {
		include get_template_directory() . '/templates/blocks/news-item.php';
	}

	/**
	 * @return WP_Post[]
	 */
	protected function getPosts() {
		if ( $this->posts ) {
			return $this->posts;
		}

		/** @var \Cactus\News\News $news */
		$news  = Bootstrap::get( \Cactus\News\News::class );
		$posts = $news->getPosts();

		$this->posts = is_array( $posts ) ? (array) $posts : [];

		return $this->posts;
	}


	/**
	 * @return int
	 */
	protected function getPageCount() {
		$this->getPosts();

		/** @var \Cactus\News\News $movie */
		$news = Bootstrap::get( \Cactus\News\News::class );

		return $news->getCountPages();
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getNewsUrl(WP_Post $post) {
		$news_url = (string) get_field('news_url', $post->ID);
		return $news_url ? $news_url : '';
	}
}
