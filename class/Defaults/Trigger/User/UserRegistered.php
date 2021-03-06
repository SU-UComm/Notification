<?php
/**
 * User registered trigger
 *
 * @package notification
 */

namespace BracketSpace\Notification\Defaults\Trigger\User;

use BracketSpace\Notification\Defaults\MergeTag;
use BracketSpace\Notification\Abstracts;

/**
 * User profile updated trigger class
 */
class UserRegistered extends Abstracts\Trigger {

	/**
	 * Constructor
	 */
	public function __construct() {

		parent::__construct( 'wordpress/user_registered', __( 'User registration', 'notification' ) );

		$this->add_action( 'register_new_user', 1000 );
		$this->add_action( 'edit_user_created_user', 1000, 2 );

		$this->set_group( __( 'User', 'notification' ) );
		$this->set_description( __( 'Fires when user registers new account', 'notification' ) );

	}

	/**
	 * Assigns action callback args to object
	 *
	 * @return void
	 */
	public function action() {

		$this->user_id     = $this->callback_args[0];
		$this->user_object = get_userdata( $this->user_id );
		$this->user_meta   = get_user_meta( $this->user_id );

		$this->user_registered_datetime = strtotime( $this->user_object->user_registered );

	}

	/**
	 * Registers attached merge tags
	 *
	 * @return void
	 */
	public function merge_tags() {

		$this->add_merge_tag( new MergeTag\User\UserID() );
    	$this->add_merge_tag( new MergeTag\User\UserLogin() );
        $this->add_merge_tag( new MergeTag\User\UserEmail() );
		$this->add_merge_tag( new MergeTag\User\UserRole() );

		$this->add_merge_tag( new MergeTag\DateTime\DateTime( array(
			'slug' => 'user_registered_datetime',
			'name' => __( 'User registration date', 'notification' ),
		) ) );

		$this->add_merge_tag( new MergeTag\UrlTag( array(
			'slug'        => 'user_password_setup_link',
			'name'        => __( 'User password setup link', 'notification' ),
			'description' => network_site_url( 'wp-login.php?action=rp&key=37f62f1363b04df4370753037853fe88&login=userlogin', 'login' ) . "\n" .
							__( 'After using this Merge Tag, no other password setup links will work.', 'notification' ),
			'example'     => true,
			'resolver'    => function( $trigger ) {
				return network_site_url( 'wp-login.php?action=rp&key=' . $trigger->get_password_reset_key() . '&login=' . rawurlencode( $trigger->user_object->user_login ), 'login' );
			},
		) ) );

    }

    /**
     * Gets password reset key
     *
     * @since  5.1.5
     * @return string
     */
    public function get_password_reset_key() {
    	return get_password_reset_key( $this->user_object );
    }

}
