<?php

namespace Cactus\Theme\Blocks;

class Slider extends AbstractBlock {

	/**
	 * @var string
	 */
	protected $slug = 'slider';

	/**
	 * @var string
	 */
	protected $title = 'Slider';

	/**
	 * @var string
	 */
	protected $icon = 'images-alt';

	/**
	 * @return array
	 */
	protected function getSlides(){
		$slidesNum = (int) $this->getData( 'slides' );
		if ( $slidesNum === 0 ) {
			return [];
		}

		$slides = [];
		for ( $i = 0; $i < $slidesNum; $i ++ ) {
			$slides[] = [
				'num'          => $i + 1,
				'image'        => $this->getData( "slides_{$i}_image" ),
				'image_mobile' => $this->getData( "slides_{$i}_image_mobile" ),
				'title'        => $this->getData( "slides_{$i}_title" ),
				'text'         => $this->getData( "slides_{$i}_text" ),
			];
		}

		return $slides;
	}
}
