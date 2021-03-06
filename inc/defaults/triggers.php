<?php
/**
 * Default triggers
 *
 * @package notification
 */

use BracketSpace\Notification\Defaults\Trigger;

// Post triggers.
if ( notification_get_setting( 'triggers/post_types/types' ) ) {

	$post_types = notification_get_setting( 'triggers/post_types/types' );

	foreach ( $post_types as $post_type ) {

		register_trigger( new Trigger\Post\PostPublished( $post_type ) );
		register_trigger( new Trigger\Post\PostUpdated( $post_type ) );
		register_trigger( new Trigger\Post\PostPending( $post_type ) );
		register_trigger( new Trigger\Post\PostTrashed( $post_type ) );

	}

}

// User triggers.
if ( notification_get_setting( 'triggers/user/enable' ) ) {

	register_trigger( new Trigger\User\UserLogin() );
	register_trigger( new Trigger\User\UserLogout() );
	register_trigger( new Trigger\User\UserRegistered() );
	register_trigger( new Trigger\User\UserProfileUpdated() );
	register_trigger( new Trigger\User\UserDeleted() );

}

// Media triggers.
if ( notification_get_setting( 'triggers/media/enable' ) ) {

	register_trigger( new Trigger\Media\MediaAdded() );
	register_trigger( new Trigger\Media\MediaUpdated() );
	register_trigger( new Trigger\Media\MediaTrashed() );

}

// Comment triggers.
if ( notification_get_setting( 'triggers/comment/types' ) ) {

	$comment_types = notification_get_setting( 'triggers/comment/types' );

	foreach ( $comment_types as $comment_type ) {

		register_trigger( new Trigger\Comment\CommentAdded( $comment_type ) );
		register_trigger( new Trigger\Comment\CommentApproved( $comment_type ) );
		register_trigger( new Trigger\Comment\CommentUnapproved( $comment_type ) );
		register_trigger( new Trigger\Comment\CommentSpammed( $comment_type ) );
		register_trigger( new Trigger\Comment\CommentTrashed( $comment_type ) );

	}

}

// WordPress triggers.
if ( notification_get_setting( 'triggers/wordpress/updates' ) ) {
	register_trigger( new Trigger\WordPress\UpdatesAvailable() );
}
