<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'twentyfifteen-fonts','genericons' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION
// 


function enqueue_custom_scripts() {
    wp_enqueue_script('custom-form-script', get_stylesheet_directory_uri() . '/custom-form-script.js', array('jquery'), null, true);
    wp_localize_script('custom-form-script', 'customForm', array(
        'nonce' => wp_create_nonce('wpforms-ajax-nonce') // Generate a nonce specific to WPForms AJAX requests
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function custom_file_upload_endpoint(WP_REST_Request $request) {
    $file_url = $request->get_param('file_url');
	
	$user_id = wp_get_current_user();

    if ($file_url) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'uploaded_media';
        $wpdb->insert($table_name, array('file' => $file_url,
										'user_id', $user_id));

        return new WP_REST_Response('File URL saved successfully.', 200);
    } else {
        return new WP_REST_Response('File URL not provided.', 400);
    }
}

function register_custom_file_upload_endpoint() {
    register_rest_route('custom/v1', '/file-upload', array(
        'methods' => 'POST',
        'callback' => 'custom_file_upload_endpoint',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
}
add_action('rest_api_init', 'register_custom_file_upload_endpoint');


function my_wpforms_process_redirect_url( $url, $form_data, $fields, $entry_id){
	if ( is_array( $form_data ) && isset( $form_data['id'] ) && $form_data['id'] === 'wpforms-form-301' ) {
		$url = rest_url('wp-json/azure-storage/v1/upload-file-media');
		// Return JSON message
        return array( 'message' => 'Redirect URL changed for form ID wpforms-form-301' );
	}
	return $url;
}

add_filter( 'wpforms_process_redirect_url', 'my_wpforms_process_redirect_url', 10, 4);

// add_filter( 'wpforms_process_complete', 'submit_wpforms_file_to_custom_endpoint', 10,4);

// function submit_wpforms_file_to_custom_endpoint($message, $form_data, $fields, $entry_id){
// 	if ( is_array( $form_data ) && isset( $form_data['id'] ) && $form_data['id'] === 'wpforms-form-301' ) {
// 		$file_input = $_FILES['wpforms_301_1'];
		
// 		if ( !empty( $file_input) ) {
// 			$file_name = $file_input['name'];
//     		$file_type = $file_input['type'];
// 			$file_tmp_name = $file_input['tmp_name'];
//     		$file_size = $file_input['size'];
			
// 			// Return JSON message
//             return array( 'message' => 'File submitted for processing for form ID wpforms-form-301' );
			
// 			$args = array(
// 				'body' => array(
// 					'form_id' => $form_data['id'],
// 					'file' => array(
// 						'name' => $file_name,
// 						'type' => $file_type,
// 						'size' => $file_size,
// 						'tmp_name' => $file_tmp_name,
// 					),
// 				),
// 			);
			
// 			$response = wp_remote_post('wp-json/azure-storage/v1/upload-file-media', $args);
			
// 			if ( is_wp_error( $response ) ){
// 				error_log( $reponse->get_error_message() );
// 			}else {
// 				$response_code = wp_remote_retrieve_response_code($response);
				
// 				if( $response_code !== 200 ){
// 					error_log( 'Failed to upload file. Response code: '. $response_code);
// 				}
// 			}
// 		}
// 	}
	
// 	return $message;
// }

// // custom endpoints 
// add_action( 'rest_api_init', function(){
//     register_rest_route( 'azure-storage/v1', 'upload-file-media', array(
//         'methods' => 'POST',
//         'callback' => 'upload_to_azure_endpoint',
// 		'args' => array(),
//         'permission_callback' => '__return_true',
//     ));
// });

// function upload_to_azure_endpoint( $request ) {
//     // Check if the request contains file data
//     $form_id = $request->get_params('form_id');
// 	$file = $request->get_file_params()[0];
	
// 	// create a new WPForms form submission
// 	$submission = WPForms_Submission::create_submission( $form_id);
	
// 	// add the file to the submission
// 	$submission->add_attachment( $file['tmp_name'], $file['name']);
	
// 	// save the submission
// 	$submission->save();

//     // Container name in Azure Storage
//     $account_name = 'mediaconnectstorage';
//     $account_key = getenv('AZURE_STORAGE_ACCOUNT_KEY') ?: '';
//     $container = 'media-files';

//     $sas_token = getenv('AZURE_STORAGE_SAS_TOKEN') ?: '';

//     // Remote path where the file will be stored in Azure Storage
//     // You can customize the remote path as needed
//     $remote_path = 'media-connect-file/' . $file['name'];

//     // Initialize the Azure Blob Storage client
//     $azure_client = new Windows_Azure_Rest_Api_Client( $account_name, $account_key );

//     // Upload the file to Azure Blob Storage
//     $result = $azure_client->put_blob( $container, $file['tmp_name'], $remote_path );

//     if ( is_wp_error( $result ) ) {
//         return new WP_Error( 'upload_failed', $result->get_error_message(), array( 'status' => 500 ) );
//     }

//     // Construct the URL of the uploaded file
//     $file_url = sprintf( 'https://%s.blob.core.windows.net/%s/%s', 
//                         $azure_client->get_account_name(), $container, 
//                         rawurlencode( $remote_path ) );

//     $file_access_url = $file_url . '?' . $sas_token;

//     global $wpdb;

//     $table_name_media = $wpdb->prefix . 'uploaded_media';
//     $table_name_metadata = $wpdb->prefix . 'uploaded_media_metadata';

//     // Sanitize user ID
//     $user_id = get_current_user_id();

//     // Insert into media table
//     $insert_result_media = $wpdb->insert( 
//         $table_name_media, 
//         array( 
//             'user_id' => intval( $user_id ),
//             'file' => esc_url_raw( $file_access_url ), // Sanitize URL
//         ), 
//         array( 
//             '%d', // user_id is an integer
//             '%s', // file is a string (file URL)
//         ) 
//     );

//     if ( ! $insert_result_media ) {
//         return new WP_Error( 'db_insert_failed', 'Failed to insert into media table', array( 'status' => 500 ) );
//     }

//     // Get the latest media ID
//     $media_id = $wpdb->get_var( "
//         SELECT media_id
//         FROM $table_name_media
//         ORDER BY date_field DESC
//         LIMIT 1
//     " );

//     // Insert metadata
//     $file_name = $file['name'];
//     $file_type = $file['type'];
//     $file_size = $file['size'];

//     $insert_result_metadata = $wpdb->insert(
//         $table_name_metadata,
//         array(
//             'media_id' => intval( $media_id ),
//             'file_name' => sanitize_text_field( $file_name ),
//             'file_type' => sanitize_text_field( $file_type ),
//             'file_size' => intval( $file_size ), 
//         ),
//         array( 
//             '%d', // media id is an integer
//             '%s', // file name
//             '%s', // file type
//             '%d', // file size
//         )
//     );

//     if ( ! $insert_result_metadata ) {
//         return new WP_Error( 'db_insert_failed', 'Failed to insert into metadata table', array( 'status' => 500 ) );
//     }

//     // Return the URI of the uploaded blob
//     return rest_ensure_response( $file_access_url );
// }

// add_action('rest_api_init', 'create_wpforms_endpoint');

function create_wpforms_endpoint(){
    register_rest_route ('myplugin/v1', '/test-file', array(
        'methods' => 'POST',
        'callback' => 'handle_wpforms_upload',
        'permission_callback' => '__return_true', // Allow unauthenticated requests for testing purposes
    ));    
}

function handle_wpforms_upload(WP_REST_Request $request){
    $files = $request->get_file_params();

    if ( empty( $files ) || empty( $files['wpforms_301_1'] ) ) {
        return new WP_Error( 'no_file', 'No file uploaded', array( 'status' => 400 ) );
    }

    $file = $_FILES['wpforms_301_1'];

    // Here you can process the file as needed.
    // For example, you can move the file to the uploads directory.
    // Example: move_uploaded_file( $file['tmp_name'], WP_CONTENT_DIR . '/uploads/' . $file['name'] );

    wp_send_json( $file ); // Send $file variable directly as JSON response
}


function handle_form_submission($fields, $entry, $form_data) {
    global $wpdb;
    
    // Your custom table name
    $table_name = $wpdb->prefix . 'custom_submissions';

    // Get current user ID
    $user_id = get_current_user_id();

    // Encode form data as JSON
    $form_data_json = json_encode($fields);

    // Insert form data into custom table
    $wpdb->insert($table_name, array(
        'user_id' => $user_id,
        'form_data' => $form_data_json
    ));
}
add_action('wpforms_process_complete', 'handle_form_submission', 10, 3);



function register_custom_endpoint() {
    register_rest_route('custom-upload-data/v1', '/submit-form', array(
        'methods' => 'POST',
        'callback' => 'submit_form_data',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'register_custom_endpoint');

function submit_form_data($request) {
    global $wpdb;

    // Your custom table name
    $table_name = $wpdb->prefix . 'custom_submissions';

    // Get current user ID
    $user_id = get_current_user_id();

    // Get form data from request
    $form_data = $request->get_params();

    // Encode form data as JSON
    $form_data_json = json_encode($form_data);

    // Insert form data into custom table
    $wpdb->insert($table_name, array(
        'user_id' => $user_id,
        'form_data' => $form_data_json
    ));

    // Optionally, you can return a response
    return new WP_REST_Response('Form data submitted successfully', 200);
}
