<?php

namespace Cactus\Theme\Blocks;

class Tiles extends AbstractBlock {
	/**
	 * @var string
	 */
	protected $slug = 'tiles';

	/**
	 * @var string
	 */
	protected $title = 'Tiles';

	/**
	 * @var string
	 */
	protected $icon = 'grid-view';

	/**
	 * @return array
	 */
	protected function getTopTiles() {
		$tilesItems = $this->getData( 'tiles' );
		if(is_array($tilesItems)){
			$tilesNum = count($tilesItems);
		} else {
			$tilesNum = (int)$tilesItems;
		}

		if ( $tilesNum === 0 ) {
			return [];
		}

		$topTilesNum = (int) ceil( $tilesNum / 2 );

		$tiles = [];
		for ( $i = 0; $i < $topTilesNum; $i ++ ) {
			$tiles[] = $this->getTile( $i );
		}

		return $tiles;
	}

	/**
	 * @return array
	 */
	protected function getBottomTiles() {
		$tilesNum = (int) $this->getData( 'tiles' );
		if ( $tilesNum === 0 ) {
			return [];
		}

		$topTilesNum = (int) ceil( $tilesNum / 2 );

		$tiles = [];
		for ( $i = $topTilesNum; $i < $tilesNum; $i ++ ) {
			$tiles[] = $this->getTile( $i );
		}

		return $tiles;
	}

	/**
	 * @param array $tile
	 */
	protected function showTile( $tile ) {
		include get_template_directory() . '/templates/blocks/tiles-item.php';
	}

	/**
	 * @param string|int $i
	 *
	 * @return array
	 */
	private function getTile( $i ) {
		$tiles = $this->getData( 'tiles' );
		if(is_array($tiles) && isset($tiles[$i])){
			return $tiles[$i];
		}

		return [
			'num'         => $i + 1,
			'image'       => $this->getData( "tiles_{$i}_image" ),
			'size'        => $this->getData( "tiles_{$i}_size" ),
			'title'       => $this->getData( "tiles_{$i}_title" ),
			'year'        => $this->getData( "tiles_{$i}_year" ),
			'description' => $this->getData( "tiles_{$i}_description" ),
		];
	}
}
