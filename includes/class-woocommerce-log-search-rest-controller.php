<?php
/**
 *  This class creates a REST API endpoint to allow searching of WooCommerce log files.
 *
 * @since 0.1
 *
 * @see register_rest_route
 * @link https://developer.wordpress.org/reference/functions/register_rest_route/
 */
class WooCommerce_Log_Search_REST_Controller {

	/**
	 * Initialize our namespace and resource name
	 *
	 * @return void
	 */
	public function __construct() {
		$this->namespace = 'wc-log-search/v1';
	}

	/**
	 * Sets the directory to search for log files.
	 *
	 * @return string
	 */
	private function get_log_directory(): string {
		return defined( WC_LOG_DIR ) ? WC_LOG_DIR : WP_CONTENT_DIR . '/uploads/wc-logs/';
	}

	/**
	 * Registers our REST API route for searching log files.
	 *
	 * @return void
	 */
	public function register_routes(): void {
		register_rest_route(
			$this->namespace,
			'/search',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'search_log_files' ),
				'permission_callback' => array( $this, 'get_wc_log_search_permissions_check' ),
			),
		);

		register_rest_route(
			$this->namespace,
			'/get_file',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'get_log_file' ),
				'permission_callback' => array( $this, 'get_wc_log_search_permissions_check' ),
			),
		);
	}

	/**
	 * Gets the contents of the selected log file.
	 *
	 * @param  object $request Current request.
	 * @return string  content.
	 */
	public function get_log_file( object $request ): string {
		$log_directory_path = $this->get_log_directory();
		$file               = $request['file'];
		$content            = file_get_contents( $log_directory_path . $file );

		return $content;
	}

	/**
	 * Loads the log files by directory and compares contents to the search term.
	 *
	 * @param  object $request Current request.
	 * @return array  The list of files that match the search term.
	 */
	public function search_log_files( object $request ): array {

		$log_directory_path = $this->get_log_directory();
		$files              = scandir( $log_directory_path );
		$string             = $request['search'];
		$result             = array();

		if ( ! empty( $files ) ) {
			foreach ( $files as $key => $value ) {
				if ( ! in_array( $value, array( '.', '..' ), true ) ) {
					if ( ! is_dir( $value ) && strstr( $value, '.log' ) ) {
						$content = file_get_contents( $log_directory_path . $value );
						if ( false !== strpos( $content, $string ) ) {
							$result[] = $value;
						}
					}
				}
			}
		}

		if ( count( $result ) === 0 ) {
			return array( 'Sorry, no results found.' );
		}
		return $result;

	}

	/**
	 * Sets up the proper HTTP status code for authorization.
	 *
	 * @return HTTP status code
	 */
	public function authorization_status_code(): int {

		$status = 401;

		if ( is_user_logged_in() ) {
			$status = 403;
		}

		return $status;
	}

	/**
	 * Check permissions for our routes.
	 *
	 * @return boolean for permissions
	 */
	public function get_wc_log_search_permissions_check(): bool {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return new WP_Error( 'rest_forbidden', esc_html__( 'You cannot view these.  Sorry!' ), array( 'status' => $this->authorization_status_code() ) );
		}
		return true;
	}
}

/**
 * Function to register our new routes from the controller.
 *
 * @return void
 */
function register_wc_log_search_routes(): void {
	$controller = new WooCommerce_Log_Search_REST_Controller();
	$controller->register_routes();
}
add_action( 'rest_api_init', 'register_wc_log_search_routes' );
