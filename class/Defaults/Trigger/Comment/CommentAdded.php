<?php
/**
 * Comment added trigger
 *
 * @package notification
 */

namespace underDEV\Notification\Defaults\Trigger\Comment;

use underDEV\Notification\Defaults\MergeTag;
use underDEV\Notification\Abstracts;

/**
 * Comment added trigger class
 */
class CommentAdded extends Abstracts\Trigger {

	/**
	 * Constructor
	 */
	public function __construct( $comment_type ) {

		parent::__construct( 'wordpress/comment_' . $comment_type . '_added', ucfirst( $comment_type ) . ' added' );

		$this->add_action( 'wp_insert_comment', 10, 2 );
		$this->set_group( __( ucfirst( $comment_type ), 'notification' ) );

		// translators: comment type.
		$this->set_description( sprintf( __( 'Fires when new %s is added', 'notification' ), __( ucfirst( $comment_type ), 'notification' ) ) );

	}

	/**
	 * Assigns action callback args to object
	 * Return `false` if you want to abort the trigger execution
	 *
	 * @return mixed void or false if no notifications should be sent
	 */
	public function action() {

		$this->comment_ID                 = $this->callback_args[0];
		$this->comment                    = $this->callback_args[1];
		$this->user_object->ID            = ( $this->comment->user_id ) ? $this->comment->user_id : 1;
		$this->user_object->user_nicename = $this->comment->comment_author;
		$this->user_object->user_email    = $this->comment->comment_author_email;

		if ( $this->comment->comment_approved == 'spam' && notification_get_setting( 'triggers/comment/akismet' ) ) {
			return false;
		}

	}

	/**
	 * Registers attached merge tags
	 *
	 * @return void
	 */
	public function merge_tags() {

		$this->add_merge_tag( new MergeTag\Comment\CommentID() );
		$this->add_merge_tag( new MergeTag\Comment\CommentContent() );
		$this->add_merge_tag( new MergeTag\Comment\CommentApproved() );
		$this->add_merge_tag( new MergeTag\Comment\CommentType() );
		$this->add_merge_tag( new MergeTag\Comment\CommentPostID() );
		$this->add_merge_tag( new MergeTag\Comment\CommentPostPermalink() );
		$this->add_merge_tag( new MergeTag\Comment\CommentAuthorIP() );
		$this->add_merge_tag( new MergeTag\Comment\CommentAuthorUserAgent() );
		$this->add_merge_tag( new MergeTag\Comment\CommentAuthorUrl() );

		// Author.
		$this->add_merge_tag( new MergeTag\User\UserID( array(
			'slug' => 'comment_author_user_ID',
			'name' => __( 'Comment author user ID' ),
		) ) );

        $this->add_merge_tag( new MergeTag\User\UserEmail( array(
			'slug' => 'comment_author_user_email',
			'name' => __( 'Comment author user email' ),
		) ) );

		$this->add_merge_tag( new MergeTag\User\UserNicename( array(
			'slug' => 'comment_author_user_nicename',
			'name' => __( 'Comment author user nicename' ),
		) ) );


    }

}
