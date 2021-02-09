<?php

namespace Cactus\Theme\Blocks;

use Cactus\Bootstrap\Bootstrap;
use Cactus\TeamMember\TeamMember;
use WP_Post;

class Team extends AbstractBlock {

	/**
	 * @var string
	 */
	protected $slug = 'team';

	/**
	 * @var string
	 */
	protected $title = 'Team';

	/**
	 * @var string
	 */
	protected $icon = 'groups';

	/**
	 * @param int $teamId
	 *
	 * @return WP_Post[]
	 */
	protected function getTeamMembersByTeamId( $teamId ) {
		/** @var TeamMember $teamMember */
		$teamMember = Bootstrap::get( TeamMember::class );

		$teamId = (int) $teamId;

		return $teamMember->getTeamMembersByTeamId( $teamId );
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getFirstName( WP_Post $post ) {
		$parts = explode( ' ', trim( $post->post_title ) );
		$parts = array_map( 'trim', $parts );

		return count( $parts ) > 1 ? $parts[0] : '';
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return string
	 */
	protected function getLastName( WP_Post $post ) {
		$parts = explode( ' ', trim( $post->post_title ) );
		$parts = array_map( 'trim', $parts );

		if ( isset( $parts[0] ) ) {
			unset ( $parts[0] );
		}

		return isset( $parts[1] ) ? implode( ' ', $parts ) : '';
	}

	/**
	 * Show modal only once
	 */
	protected function showModal() {
		$this->showTemplateOnce('modal.php');
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