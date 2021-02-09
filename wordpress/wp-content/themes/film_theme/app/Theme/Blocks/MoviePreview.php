<?php

namespace Cactus\Theme\Blocks;

use WP_Post;

class MoviePreview extends AbstractBlock {

	/**
	 * @var string
	 */
	protected $slug = 'movie-preview';

	/**
	 * @var string
	 */
	protected $title = 'Movie Preview';

	/**
	 * @var WP_Post
	 */
	protected $currentMovie;

	/**
	 * @var string
	 */
	protected $icon = 'format-video';

	/**
	 * @param mixed $data
	 *
	 * @return $this|AbstractBlock
	 */
	public function setData( $data ) {
		parent::setData( $data );

		$movieData = get_fields( $this->getMovieId() );
		if ( $movieData ) {
			$this->block['data'] = array_merge( $this->block['data'], $movieData );
		}

		return $this;
	}

	/**
	 * @return int
	 */
	protected function getMovieId() {
		return (int) $this->getData( 'movie_preview_id' );
	}

	/**
	 * @return WP_Post|null
	 */
	protected function getMovie() {
		if ( $this->currentMovie ) {
			return $this->currentMovie;
		}

		$movie = get_post( $this->getMovieId() );

		if ( $movie instanceof WP_Post ) {
			$this->currentMovie = $movie;

			return $this->currentMovie;
		}

		return null;
	}

	/**
	 * @return string
	 */
	protected function getTitle() {
		return $this->getMovie() ? $this->getMovie()->post_title : '';
	}


	/**
	 * @param int $image_id
	 * @param string $size
	 * @param bool $icon
	 * @param string $additional
	 *
	 * @return string
	 */
	protected function getImgAsDiv( $image_id, $size = 'thumbnail', $icon = false, $additional = '' ) {
		$img = $this->getAttachmentImg( $image_id, $size, $icon, $additional );

		return str_replace( '<img', '<div', $img ) . '</div>';
	}
}
