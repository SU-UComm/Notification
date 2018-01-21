<?php

namespace underDEV\Notification\Defaults\Field;
use underDEV\Notification\Abstracts\Field;

class EditorField extends Field {

	/**
	 * Editor settings
	 * @see https://codex.wordpress.org/Function_Reference/wp_editor#Arguments
	 * @var string
	 */
	protected $settings = 'text';

	public function __construct( $params = array() ) {

		if ( isset( $params['settings'] ) ) {
    		$this->settings = $params['settings'];
    	}

		parent::__construct( $params );

	}

	/**
	 * Returns field HTML
	 * @return string html
	 */
	public function field() {

		$settings = wp_parse_args( $this->settings, array(
			'textarea_name'       => $this->get_name(),
			'textarea_rows'       => 20,
		) );

		ob_start();

		wp_editor( $this->get_value(), $this->get_id(), $settings );

		return ob_get_clean();

	}

	/**
     * Sanitizes the value sent by user
     * @param  mixed $value value to sanitize
     * @return mixed        sanitized value
     */
    public function sanitize( $value ) {
    	return wp_kses_post( $value );
    }

}
