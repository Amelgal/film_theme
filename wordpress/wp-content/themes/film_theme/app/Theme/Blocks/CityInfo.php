<?php

namespace Cactus\Theme\Blocks;

use Cactus\TeamMember\TeamMember;
use WP_Post;

class CityInfo extends AbstractBlock {
	/**
	 * @var string
	 */
	protected $slug = 'city-info';

	/**
	 * @var string
	 */
	protected $title = 'City Info';

	/**
	 * @return WP_Post[]
	 */
	protected function getTeamMembers() {
		$teamId = (int) $this->getData( 'cityinfo-team' );
		/** @var TeamMember $teamMember */
		$teamMember = \Cactus\Bootstrap\Bootstrap::get( TeamMember::class );

		return $teamMember->getTeamMembersByTeamId( $teamId );
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getMemberFirstName( WP_Post $post ) {
		$titleParts = explode( ' ', $post->post_title );

		return isset( $titleParts[0] ) ? $titleParts[0] : '';
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getMemberLastName( WP_Post $post ) {
		$titleParts = explode( ' ', $post->post_title );
		$titleParts = array_map( 'trim', $titleParts );

		if ( isset( $titleParts[0] ) ) {
			unset ( $titleParts[0] );
		}

		return isset( $titleParts[1] ) ? implode( ' ', $titleParts ) : '';
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getMemberJobTitle( WP_Post $post ) {
		return (string) get_field( 'job_title', $post->ID );
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getMemberAdditional( WP_Post $post ) {
		return (string) get_field( 'team_additional_info', $post->ID );
	}
}
