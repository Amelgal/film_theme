<?php

namespace Cactus\Theme\Blocks;

class Video extends AbstractBlock {

	/**
	 * @var string
	 */
	protected $slug = 'video';

	/**
	 * @var string
	 */
	protected $title = 'Video';

	/**
	 * @var string
	 */
	protected $icon = 'format-video';

	/**
	 * @return string
	 */
	protected function getIframe(){
		return (string)$this->getData( 'video_iframe' );
	}
}
