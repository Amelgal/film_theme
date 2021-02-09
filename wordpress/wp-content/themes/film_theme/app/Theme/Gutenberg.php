<?php

namespace Cactus\Theme;

use Cactus\Bootstrap\Bootstrap;

class Gutenberg {

	/**
	 * Gutenberg constructor.
	 */
	public function __construct() {
		$this->registerBlocks();

		add_filter( 'block_categories', [ $this, 'registerCategory' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'adminBlocksStyle' ] );
	}

	/**
	 * Register Blocks Category
	 *
	 * @param $categories
	 *
	 * @return array
	 */
	public function registerCategory( $categories ) {
		return array_merge(
			$categories,
			[
				[
					'slug'  => 'gaumont',
					'title' => 'Gaumont',
				]
			]
		);
	}

	/**
	 * Register blocks
	 */
	private function registerBlocks() {
		Bootstrap::get( \Cactus\Theme\Blocks\Slider::class );
		/*Bootstrap::get( \Cactus\Theme\Blocks\Tiles::class );
		Bootstrap::get( \Cactus\Theme\Blocks\Content::class );
		Bootstrap::get( \Cactus\Theme\Blocks\CityInfo::class );
		Bootstrap::get( \Cactus\Theme\Blocks\Text::class );
		Bootstrap::get( \Cactus\Theme\Blocks\Team::class );
		Bootstrap::get( \Cactus\Theme\Blocks\Movies::class );
		Bootstrap::get( \Cactus\Theme\Blocks\Carousel::class );
		Bootstrap::get( \Cactus\Theme\Blocks\Video::class );
		Bootstrap::get( \Cactus\Theme\Blocks\MoviePreview::class );
		Bootstrap::get( \Cactus\Theme\Blocks\News::class );*/
	}

	/**
	 * Add styles to backend add/edit page
	 */
	public function adminBlocksStyle() {
		global $pagenow;

		if ( $pagenow === 'post.php' || $pagenow === 'post-new.php' ) {
			wp_enqueue_style(
				'gaumont-blocks-style',
				get_template_directory_uri() . '/assets/build/css/backend.min.css'
			);
		}
	}
}