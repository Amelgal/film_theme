<?php

namespace Cactus\Theme;

class Theme {

	/**
	 * Theme constructor.
	 */
	public function __construct() {
  	add_action( 'wp_enqueue_scripts', [ $this, 'addJsVars' ] );
		add_action( 'admin_menu', [ $this, 'removeMenuItems' ] );
		add_action( 'after_setup_theme', [ $this, 'registerSizes' ] );

		$this->registerMenu();
		$this->addSupport();

		if ( is_admin() ) {
			$this->loadAcf();
		}

		if ( defined( 'IS_PRODUCTION' ) && IS_PRODUCTION ) {
			include_once get_template_directory() . '/app/Theme/AcfConfigs/all_groups.php';
		}

		\Cactus\Bootstrap\Bootstrap::get( \Cactus\Theme\Gutenberg::class );
	}

	/**
	 * Load all config related to ACF
	 */
	private function loadAcf() {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page( array(
				'page_title' => __( 'Gaumont' ),
				'menu_title' => __( 'Gaumont' ),
				'capability' => 'manage_options',
			) );
		}
	}

	/**
	 * Register static content
	 */

	public function addJsVars() {
		$vars = [
			'movie'       => admin_url( 'admin-ajax.php?action=lazyload_movie' ),
			'news'        => admin_url( 'admin-ajax.php?action=lazyload_news' ),
			'city_movies' => admin_url( 'admin-ajax.php?action=lazyload_city_movies' )
		];

		wp_localize_script( 'gaumont-script', 'gaumont_lazyload', $vars );
	}

	public function removeMenuItems() {
		global $submenu;

		remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'customize.php' );

		if ( isset( $submenu['themes.php'] ) ) {
			foreach ( $submenu['themes.php'] as $index => $menu_item ) {
				if ( in_array( 'Customize', $menu_item ) ) {
					unset( $submenu['themes.php'][ $index ] );
				}
			}
		}
	}

	public function registerSizes() {
		add_image_size( 'fullscreen', 1920, 1920 );
	}

	/**
	 * Register menu locations
	 */
	private function registerMenu() {
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				array(
					'primary' => __( 'Primary' ),
				)
			);
		}
	}

	private function addSupport() {
		add_theme_support( 'post-thumbnails' );
	}
}
