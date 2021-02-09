<?php

namespace Cactus\Theme\Blocks;

use WP_Post;

abstract class AbstractBlock {

	/**
	 * @var string
	 */
	protected $slug = '';

	/**
	 * @var string
	 */
	protected $title = '';

	/**
	 * @var array
	 */
	protected $block = [];

	/**
	 * @var AbstractBlock[]
	 */
	protected $subBlocks = [];

	/**
	 * @var string
	 */
	protected $icon = '';

	/**
	 * AbstractBlock constructor.
	 */
	public function __construct() {
		add_action( 'acf/init', [ $this, 'register' ] );
	}

	/**
	 * Register Block
	 */
	public function register() {
		$icon = $this->icon ? $this->icon : 'tagcloud';

		if ( function_exists( 'acf_register_block' ) ) {
			acf_register_block( [
				'name'            => 'gaumont_' . $this->slug,
				'title'           => __( $this->title ),
				'render_callback' => [ $this, 'render' ],
				'category'        => 'gaumont',
				'icon'            => $icon,
				'keywords'        => array( $this->slug ),
				'align'           => 'full',
			] );
		}
	}

	/**
	 * @param array $block
	 */
	public function render( $block = null ) {
		if ( $block ) {
			if ( isset( $block['data'] ) && is_admin() ) {
				$this->setData( get_fields() );
			} elseif ( isset( $block['data'] ) ) {
				$this->setData( $block['data'] );
			} else {
				$this->setData( $block );
			}
		}
		include get_template_directory() . '/templates/blocks/' . $this->slug . '.php';
	}

	/**
	 * @param mixed $data
	 *
	 * @return $this
	 */
	public function setData( $data ) {
		$this->block['data'] = $data;

		return $this;
	}

	/**
	 * @param AbstractBlock $object
	 * @param string $name
	 *
	 * @return $this
	 */
	public function addSubBlock( AbstractBlock $object, $name ) {
		$this->subBlocks[ $name ] = $object;

		return $this;
	}

	/**
	 * @param string $name
	 */
	protected function renderSubBlock( $name ) {
		if ( isset( $this->subBlocks[ $name ] ) ) {
			$this->subBlocks[ $name ]->render();
		}
	}

	/**
	 * @param string $var
	 *
	 * @return array
	 */
	protected function getData( $var = '' ) {
		if ( empty( $var ) ) {
			return isset( $this->block['data'] ) ? $this->block['data'] : [];
		} else {
			return isset( $this->block['data'][ $var ] ) ? $this->block['data'][ $var ] : null;
		}
	}

	/**
	 * @return WP_Post|null
	 */
	protected function getCurrentPost() {
		global $post;

		if ( ! $post && isset( $_REQUEST['post_id'] ) && $post_id = (int) $_REQUEST['post_id'] ) {
			$post = get_post( $post_id );
		}

		return $post instanceof \WP_Post ? $post : null;
	}

	/**
	 * @param WP_Post $post
	 * @param string $size
	 * @param bool $icon
	 * @param string $attr
	 *
	 * @return string
	 */
	protected function getPostThumbnailImg( WP_Post $post, $size = 'thumbnail', $icon = false, $attr = '' ) {
		$attachment_id = (int) get_post_thumbnail_id( $post );
		if ( $attachment_id === 0 ) {
			return '';
		}

		return wp_get_attachment_image( $attachment_id, $size, $icon, $attr );
	}

	/**
	 * @param int $attachmentId
	 * @param string $size
	 * @param bool $icon
	 * @param string $attr
	 *
	 * @return string
	 */
	protected function getAttachmentImg( $attachmentId, $size = 'thumbnail', $icon = false, $attr = '' ) {
		return wp_get_attachment_image( $attachmentId, $size, $icon, $attr );
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getPermalink( WP_Post $post ) {
		$link = get_permalink( $post );

		return $link ? $link : '';
	}

	/**
	 * @param string $path
	 */
	protected function showTemplateOnce( $path ) {
		$path = get_template_directory() . "/templates/" . $path;
		if ( is_file( $path ) ) {
			include_once $path;
		}
	}

	protected function showTemplate( $path ) {
		include get_template_directory() . '/templates/' . $path;
	}
}