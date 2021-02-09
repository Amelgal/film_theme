<?php

namespace Cactus\Theme\Blocks;

class Carousel extends AbstractBlock {

	/**
	 * @var string
	 */
	protected $slug = 'carousel';

	/**
	 * @var string
	 */
	protected $title = 'Carousel';

	/**
	 * @var string
	 */
	protected $icon = 'images-alt';

	/**
	 * @return array
	 */
	protected function getItems() {
		return (array)$this->getData( 'carousel_items' );
	}
}
