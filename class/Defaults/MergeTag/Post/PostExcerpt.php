<?php
/**
 * Post excerpt merge tag
 *
 * Requirements:
 * - Trigger property of the post type slug with WP_Post object
 *
 * @package notification
 */

namespace underDEV\Notification\Defaults\MergeTag\Post;

use underDEV\Notification\Defaults\MergeTag\StringTag;


/**
 * Post excerpt merge tag class
 */
class PostExcerpt extends StringTag {

	/**
	 * Post Type slug
	 *
	 * @var string
	 */
	protected $post_type;

	/**
     * Merge tag constructor
     *
     * @since [Next]
     * @param array $params merge tag configuration params.
     */
    public function __construct( $params = array() ) {

    	if ( isset( $params['post_type'] ) ) {
    		$this->post_type = $params['post_type'];
    	} else {
    		$this->post_type = 'post';
    	}

    	$args = wp_parse_args( $params, array(
			'slug'        => $this->post_type . '_excerpt',
			// translators: singular post name.
			'name'        => sprintf( __( '%s excerpt' ), $this->get_nicename() ),
			'description' => __( 'Welcome to WordPress...' ),
			'example'     => true,
			'resolver'    => function() {
				return get_the_excerpt( $this->trigger->{ $this->post_type } );
			},
		) );

    	parent::__construct( $args );

	}

	/**
	 * Function for checking requirements
	 *
	 * @return boolean
	 */
	public function check_requirements() {
		return isset( $this->trigger->{ $this->post_type } );
	}

	/**
	 * Gets nice, translated post name
	 *
	 * @since  [Next]
	 * @return string post name
	 */
	public function get_nicename() {
		return get_post_type_object( $this->post_type )->labels->singular_name;
	}

}
