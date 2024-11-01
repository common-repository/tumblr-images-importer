<?php
/*
Plugin Name: Tumblr Image Importer
Plugin URI: http://estudiopasto.com
Description: Thank you for installing my plugin!. You can find the options under Settings > Tumblr Importer (beta). Remember that this is a beta plugin, meaning that could contain errors. Please write me an email if you need any help.
Author: Rodrigo Catalano
Author URI: http://estudiopasto.com
*/
/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
    add_options_page( 'My Plugin Options', 'Tumblr Importer (beta)', 'manage_options', 'importador-tumblr-test', 'importador_tumblr' );
}

/** Step 3. */
function importador_tumblr() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <h1>Tumblr Importer</h1>
    <p>This plugin was made to import all images from your tumblr (or any tumblr) and add them as wordpress pots. The images will be set as Featured Images. Take in consideration that it could take a long time depending on the amount of images to be retrieved.<br>
    As Tumblr dosnt have Titles for each image, they will be imported as N° 1..N° 2.. etc</p>
    <p><strong>Firt:</strong> Click on Fetch Images to retrieve the total amount of images of the tumblr blog (it could take a while)</p>
    <p><strong>Second:</strong> Click on Start! to begin the process of inserting the posts</p>
    <hr>
    <form id="ajax_form" method="post">
        <label>Tumblr Name</label>
        <input type="text" name="tumblr_name">.tumblr.com
        <br>
        <input type="button" class="fetch" value="Fetch Images"><br>
        <span class="working" style="display: none"><img src="<?php echo site_url().'/wp-content/plugins/images-tumblr-importer/' ?>ajax-loader.gif"> Working...please wait (this could take a while)</span>
        <br>
        <span class="images_amount"></span>
        <br>
        <hr>
		<label>Starting Image</label>
		<input type="text" name="start_images" value="0"><br>
        <label>Amount of images to be inserted (write <strong>all</strong> for all images)</label>
        <input type="text" name="amount_images" value="all"> <span class="maximum_images"></span>
        <br>
        <label>Default Post Type</label>
        <select name="default_type">
            <option value="standard">Standard</option>
            <option value="aside">Aside</option>
            <option value="chat">Chat</option>
            <option value="gallery">Gallery</option>
            <option value="link">Link</option>
            <option value="image">Image</option>
            <option value="quote">Quote</option>
            <option value="status">Status</option>
            <option value="video">Video</option>
            <option value="audio">Audio</option>
        </select>
        <br>
        <label>Set posts as</label>
        <select name="set_post_as">
            <option value="publish">Published</option>
            <option value="draft">Draft</option>
        </select>
        <br>
        <label>Set post author to</label>
		<select name="user_author">
		<?php
		    $blogusers = get_users('blog_id=1&orderby=nicename');
		    foreach ($blogusers as $user) {
		        echo '<option value="'.$user->ID.'">' . $user->user_nicename . '</option>';
		    }
		?>
		</select>
        <input type="submit" class="start" value="Start!">
    </form>
    <span class="enproceso" style="display: none">Started! Please wait... this could take a long time depending on the ammount of images to be inserted</span><br>
    <span class="proceso"></span>
    <br>
    <hr>
    <p>If you have any problems with this plugin, please contact me <a href="mailto:rodrigo@estudiopasto.com">rodrigo@estudiopasto.com</a></p>
    <p>Thank you for using my plugin!</p>
    <p><strong>This plugin is complety free and it will be free always. If you like it and want to make a donation to help improving please click the following button :)</strong></p>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
	">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
<?php } ?>
<?php

add_action("wp_ajax_Tumblr_GetAmount", "Tumblr_GetAmount");
add_action("wp_ajax_nopriv_Tumblr_GetAmount", "Tumblr_GetAmount");
function Tumblr_GetAmount(){
    global $wpdb;

    require 'clearbricks/_common.php';
    require 'class.read.tumblr.php';
	
    $oTumblr = new readTumblr($_POST['tumblr_name']);
    $oTumblr->getPosts(0,'all','images');
    $aTumblr = $oTumblr->dumpArray();
    $counter = 0;
    if (!empty($aTumblr['posts'])){
        foreach($aTumblr['posts'] as $p){
            if (isset($p['content']['url-1280'])){
                $counter++;
            }
        }
        echo $counter;
    } else {
        echo 'There are no images here!';
    }
    die();
}


add_action("wp_ajax_MyPlugin_GetVars", "MyPlugin_GetVars");
add_action("wp_ajax_nopriv_MyPlugin_GetVars", "MyPlugin_GetVars");
function MyPlugin_GetVars(){
    global $wpdb;

    require 'clearbricks/_common.php';
    require 'class.read.tumblr.php';

    $start = $_POST['start'];
	$max = $_POST['amount_images'];
    $oTumblr = new readTumblr($_POST['tumblr_name']);

    $oTumblr->getPosts($start,1,'images');

    $aTumblr = $oTumblr->dumpArray();

	
    foreach($aTumblr['posts'] as $p){

        if (isset($p['content']['url-1280'])){
			
            // Register Post Data
            $post = array();
            $post['post_status']   = $_POST['set_post_as'];
            $post['post_type']     = 'post'; // can be a CPT too
            $post['post_title']    = 'N° '.$start;
            $post['post_content']  = '.';
            $post['post_author']   = $_POST['user_author'];

            // Create Post
            $post_id = wp_insert_post( $post, TRUE );
            set_post_format($post_id, $_POST['default_type'] );



            // Add Featured Image to Post
            $image_url  = $p['content']['url-1280']; // Define the image URL here
            $upload_dir = wp_upload_dir(); // Set upload folder
            $image_data = file_get_contents($image_url); // Get image data
            $filename   = basename($image_url); // Create image file name

            // Check folder permission and define file location
            if( wp_mkdir_p( $upload_dir['path'] ) ) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }

            // Create the image  file on the server
            file_put_contents( $file, $image_data );

            // Check image file type
            $wp_filetype = wp_check_filetype( $filename, null );

            // Set attachment data
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name( $filename ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            // Create the attachment
            $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

            // Include image.php
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Define attachment metadata
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

            // Assign metadata to attachment
            wp_update_attachment_metadata( $attach_id, $attach_data );

            // And finally assign featured image to post
            set_post_thumbnail( $post_id, $attach_id );
			$data['counter'] = $start;
            //echo 'Importing.. N°'.$start;
			echo json_encode($data);
			break;
        }
    }
    die();
}




add_action( 'admin_footer', 'my_action_javascript' );

function my_action_javascript() {  ?>
    <script>
        jQuery(document).ready(function($){

            $('.fetch').on('click',function(e){
                e.preventDefault();
                var tumblr_name    = $('input[name="tumblr_name"]').val();
                $('.fetch').attr('disabled', 'disabled');
                $('.working').show();
                get_ammount(tumblr_name);
            })

            $('#ajax_form').on('submit', function(e) {
                e.preventDefault()
                $('input[type=submit]', this).attr('disabled', 'disabled');


                var tumblr_name    = $('input[name="tumblr_name"]').val();
                var amount_images  = $('input[name="amount_images"]').val();
                var default_type   = $('select[name="default_type"]').val();
                var set_post_as    = $('select[name="set_post_as"]').val();
				var user_author    = $('select[name="user_author"]').val();

                $('.enproceso').show();
                var start = $('input[name="start_images"]').val();
				var continueFlag = true;
                var iT = setInterval(function(){
					if (continueFlag){
						continueFlag = false;
						save_data(start,default_type,set_post_as,amount_images,tumblr_name,user_author).done(function(response){
							continueFlag = true;
							if (amount_images == 'all'){
								allImages = $('.allImages').text();
								$('.proceso').html('Importing '+response.counter+' of '+allImages);
							} else {
								$('.proceso').html('Importing '+response.counter+' of '+amount_images);
							}
						
						});
						if (amount_images != 'all'){
							if (start >= amount_images){
								clearInterval(iT)
								$('input[type=submit]').removeAttr('disabled');
								$('.enproceso').hide();
								$('.proceso').text('Completed!');
							}
						} else {
							allImages = $('.allImages').text();
							if (start > parseInt(allImages)){
								clearInterval(iT)
								$('input[type=submit]').removeAttr('disabled');
								$('.enproceso').hide();
								$('.proceso').text('Completed!');
							}
						}
						start++;
					}
                }, 10000);
				
            })
            function get_ammount(tumblr_name){
                $.ajax({
                    url:'<?php echo admin_url("admin-ajax.php", null); ?>',
                    data: {
                        action: 'Tumblr_GetAmount',
                        tumblr_name: tumblr_name
                    },
                    type: 'POST',
                    dataType: 'html',
                    success: function(response){
                        allImages = response;
                        $('.images_amount').html('Total images found: <span class="allImages">'+response+'</span>');
                        $('.maximum_images').text('(Max ammount '+response+')');
                        $('.fetch').removeAttr('disabled');
                        $('.working').hide();
                    }
                })
            }
            function save_data(start,default_type,set_post_as,amount_images,tumblr_name,user_author){
                return $.ajax({
                    url:'<?php echo admin_url("admin-ajax.php", null); ?>',
                    data: {
                        action: 'MyPlugin_GetVars',
                        start:start,
                        tumblr_name:tumblr_name,
                        default_type: default_type,
                        set_post_as: set_post_as,
                        amount_images: amount_images,
						user_author: user_author

                    },
                    type: 'POST',
                    dataType: 'json'
                    
                })
            }
        })
    </script>
<?php
}