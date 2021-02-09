<?php

namespace Cactus\Theme\Blocks;

use \Cactus\Bootstrap\Bootstrap;
use Cactus\Movie\Movie as Movies;
use WP_Post;
use WP_Term;

class Content extends AbstractBlock {
	/**
	 * @var string
	 */
	protected $slug = 'content';

	/**
	 * @var string
	 */
	protected $title = 'Content';

	/**
	 * @var Movies
	 */
	protected $movies;

	/**
	 * @var string
	 */
	protected $icon = 'grid-view';

	/**
	 * @var WP_Post[]
	 */
	private $posts;

	/**
	 * Content constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->movies = Bootstrap::get( Movies::class );
	}

	/**
	 * @param WP_Post $movie
	 */
	public function renderItem( WP_Post $movie ) {
		include get_template_directory() . '/templates/blocks/content-item.php';
	}

	/**
	 * Get array of term for the types taxonomy
	 * @return WP_Term[]
	 */
	protected function getMovieTypes() {
		$terms = $this->movies->getAllTypes();
		if ( is_array( $terms ) ) {
			return $terms;
		}

		return [];
	}

	/**
	 * Get Array of movie posts
	 * @return WP_Post[]
	 */
	protected function getMovies() {
		if ( $this->posts ) {
			return $this->posts;
		}

		$posts = $this->movies->getPosts();

		$this->posts = is_array( $posts ) ? $posts : [];

		return $this->posts;
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return WP_Term[]
	 */
	protected function getPostTypes( WP_Post $post ) {
		$terms = wp_get_post_terms( $post->ID, 'types' );
		if ( is_array( $terms ) ) {
			return $terms;
		}

		return [];
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getPostTypesClasses( WP_Post $post ) {
		$classes = [];
		foreach ( $this->getPostTypes( $post ) as $type ) {
			$classes[] = 'type-' . $type->slug;
		}

		return join( ' ', $classes );
	}

	/**
	 * @return int
	 */
	protected function getPageCount() {
		$this->getMovies();

		return $this->movies->getCountPages();
	}
}
