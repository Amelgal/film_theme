<?php

namespace Cactus\Theme\Blocks;

use Cactus\Bootstrap\Bootstrap;
use Cactus\Movie\Movie;
use WP_Post;

class Movies extends AbstractBlock {
	/**
	 * @var string
	 */
	protected $slug = 'movies';

	/**
	 * @var string
	 */
	protected $title = 'Movies';

	/**
	 * @var string
	 */
	protected $icon = 'playlist-video';

	/**
	 * @var WP_Post[]
	 */
	private $items = [];

	/**
	 * @param WP_Post $item
	 */
	public function renderItem( WP_Post $item ) {
		include get_template_directory() . '/templates/blocks/movies-item.php';
	}

	/**
	 * @param int $team_id
	 *
	 * @return WP_Post[]
	 */
	protected function getItems( $team_id ) {
		if ( $this->items ) {
			return $this->items;
		}

		$team_id = (int) $team_id;

		/** @var Movie $movie */
		$movie = Bootstrap::get( Movie::class );

		$movie->setNumberPosts( (int) get_field( 'ppp_international', 'option' ) );

		$this->items = $movie->getMoviesByTeamId( $team_id );

		return $this->items;
	}

	/**
	 * @param int $team_id
	 *
	 * @return int
	 */
	protected function getPageCount( $team_id ) {
		/** @var Movie $movie */
		$movie = Bootstrap::get( Movie::class );

		$team_id = (int) $team_id;
		$this->getItems( $team_id );

		return $movie->getCountPages();
	}
}
