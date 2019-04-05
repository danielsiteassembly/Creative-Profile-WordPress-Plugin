<?php
add_action('post_edit_form_tag', 'add_post_enctype');

function add_post_enctype() {
    echo ' enctype="multipart/form-data"';
}
// Create custom metas
function couple_meta_init()
{
	add_meta_box(
        'couple_settings',
        'Couple Details',
        'couple_settings',
        'couples'
    );
}
add_action('add_meta_boxes', 'couple_meta_init');


// Return function
function couple_settings($post)
{
	$post_id = $post->ID;
	$couple_name = get_post_meta($post_id, 'cpl_name', true);
	$couple_date_event = get_post_meta($post_id, 'cpl_eve_date', true);
	$couple_location = get_post_meta($post_id, 'cpl_location', true);
	$couple_description = get_post_meta($post_id, 'cpl_description', true);
	$couple_profile_image = get_post_meta($post_id, 'profile_image', true);
	$couple_gallary_images = get_post_meta($post_id, 'couple_gallary_images', true);
	$couple_gallary_videos = get_post_meta($post_id, 'couple_gallary_videos', true);
	$couplr_grid_type = get_post_meta($post_id, 'cpl_grid_type', true);
	?>
	<style type="text/css">
		.couple-form
		{
			width: 50%;
		    height: 40px;
		    box-shadow: none;
		    margin-top: 1.5%;
		}
		.ui-datepicker .ui-datepicker-next span, .ui-datepicker .ui-datepicker-prev span
		{
			background-color: #909090;
			border-radius: 50%;
		}
		.mt-2p
		{
			margin-top: 2%;
		}
		.rmv-height
		{
			height: auto;
		}
		.append_error
		{
			color: red;
		}
		.display-flex-center
		{
			display: flex;
			align-items: center;
		}
		.btn-container
		{
			margin-left: 10px;
			position: relative;
		    width: 50px;
		    height: 28px;
		}
		.btn-container > #profile-image, .btn-container > #couple-gallary-image, .btn-container > #couple-gallary-videos
		{
			position: absolute;
		    top: 0;
		    left: 0;
		    width: 28px;
		    height: 28px;
		    opacity: 0;
		}
		.append_gallary_images, .append_gallary_video
		{
			display: inline-flex;
			flex-wrap: wrap;
		}
		.gallary-images > img
		{
			width: 100px;
		}
		.gallary-images
		{
			margin: 5px;
			position: relative;
		}
		.gallary-images > span
		{
			position: absolute;
		    top: 2px;
		    right: 4px;
		    color: white;
		    opacity: 0.8;
		    cursor: pointer;
		}
		.rowclear:after
		{
			content: "";
		    clear: both;
		    display: table;
		}
		.vr-text-top
		{
			vertical-align: text-top;
		}
		.video-extra-field
		{
			display: flex;
			align-items: center;
		}
		.cpl-player-type-container
		{
			margin-top: 1.5%;
			margin-left: 10px;
		}
		.cpl-remove-text-video-field
		{
			margin-top: 1.5%;
		}
		.cpl-grid-size-container
		{
			position: relative;
		}
	</style>
	<div class="container">
		<div class="mt-2p">
			<div class="lbl-container">
				<label><strong><span>*</span> Date of event</strong></label>
			</div>
			<div class="inpt-container" id="couple_date_event">
				<input type="text" name="couple-date-event" class="couple-form" id="datepicker" value="<?php echo $couple_date_event; ?>">
			</div>
			<span class="append_error"></span>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				// Datepicker Popups calender to Choose date.
				jQuery(function() {
					jQuery("#datepicker").datepicker();
					// Pass the user selected date format.
					jQuery("#format").change(function() {
					jQuery("#datepicker").datepicker("option", "dateFormat",'yy-mm-dd');
					});
				});
			});
    	</script>

    	<div class="mt-2p">
	    	<div class="lbl-container">
				<label><strong><span>*</span> Location</strong></label>
			</div>
			<div class="inpt-container" id="couple_event_location">
				<input type="text" name="couple-location" id="couple-event-location" class="couple-form" placeholder="Event Location" value="<?php echo $couple_location; ?>">
			</div>
			<span class="append_error"></span>
		</div>

		<!-- Upload Single Profile Image -->
		<div class="mt-2p">
	    	<div class="lbl-container display-flex-center">
				<label><strong><span>*</span> Profile Image</strong></label>
				<div class="btn-container">
					<span class="fa fa-camera fa-2x"></span>
					<input type="file" name="profile-image" class="couple-form" id="profile-image" onchange="readURL(this)">
				</div>
			</div>
			<div class="inpt-container" id="profile_image">
				<div>
					<img src="<?php if(!empty($couple_profile_image['url'])) { echo $couple_profile_image['url']; } ?>" width="265px" name="profile-image-tag" id="profile-image-tag" <?php if(empty($couple_profile_image)) { echo "style='display: none;'"; } ?>>
				</div>
			</div>
			<span class="append_error"></span>
		</div>

		<!-- Upload Multiple Images -->
		<div class="mt-2p">
	    	<div class="lbl-container display-flex-center">
				<label><strong><span>*</span> Upload Photos</strong></label>
				<div class="btn-container">
					<span class="fa fa-th-large fa-2x"></span>
					<input type="file" name="couple-gallary-image[]" class="couple-form" id="couple-gallary-image" multiple="multiple" onchange="gallaryImages(event)">
				</div>
				<div class="cpl-grid-size-container">
					<input type="radio" name="grid-type" class="grid-type" value="1" data-grid-type="masonry" <?php if($couplr_grid_type == 1) { echo "checked=checked"; } ?>>
					<label><strong>Masonry</strong></label>&nbsp&nbsp
					<input type="radio" name="grid-type" class="grid-type" value="2" data-grid-type="2 column" <?php if($couplr_grid_type == 2 ) { echo "checked=checked"; } ?>>
					<label><strong>2 Column</strong></label>&nbsp&nbsp
					<input type="radio" name="grid-type" class="grid-type" value="3" data-grid-type="3 column" <?php if($couplr_grid_type == 3) { echo "checked=checked"; } ?>>
					<label><strong>3 Column</strong></label>&nbsp&nbsp
				</div>
			</div>
			<div class="inpt-container" id="couple-photo-gallary">
				<div class="append_gallary_images">
					<?php if(!empty($couple_gallary_images) && count($couple_gallary_images) > 0){ ?>
						<?php $img_gallary_counter = 1; ?>
						<?php foreach($couple_gallary_images as $key => $data): ?>
							<div class='gallary-images' id='gallary_image<?php echo $img_gallary_counter; ?>'><span class="fa fa-close ajax-remove"></span><img class='gallary_image' data-path="<?php echo $data['file']; ?>" src='<?php echo $data["url"]; ?>'></div>
							<?php $img_gallary_counter++; ?>
						<?php endforeach; ?>
					<?php } ?>
				</div>
			</div>
			<span class="append_error"></span>
		</div>

		<div class="mt-2p">
	    	<div class="lbl-container display-flex-center">
				<label><strong><span>*</span> Upload Videos</strong></label>
				<div class="btn-container add_text_field">
					<span class="fa fa-video-camera fa-2x"></span> <span class="fa fa-plus vr-text-top"></span>
				</div>
			</div>
			<div class="inpt-container" id="couple-video-gallary">
				<?php if(!empty($couple_gallary_videos) && count($couple_gallary_videos) > 0){ ?>
						<?php $video_counter = 1; ?>
						<?php foreach($couple_gallary_videos as $key2 => $data2): ?>
						<div class="video-extra-field">
							<input type="text" name="couple_gallary_videos[]" class="couple-form couple_gallary_videos" placeholder="Add Video Url" value="<?php echo $data2['link']; ?>">
							<?php if($video_counter > 1){ ?>
							<button type="button" class="cpl-remove-text-video-field">
								<span class="fa fa-close"></span>
							</button>
							<?php } ?>
							<div class="cpl-player-type-container">
								<label>Youtube</label>
								<input type="checkbox" name="player-type[]" value="1" class="player-type" <?php if($data2['type'] == 1) { echo "checked='checked'"; } ?>>

								<label>Vimeo</label>
								<input type="checkbox" name="player-type[]" value="2" class="player-type" <?php if($data2['type'] == 2) { echo "checked='checked'"; } ?>>
							</div>
						</div>
						<?php $video_counter++; ?>
					<?php endforeach; ?>
				<?php }
					else
					{
					?>
					<div class="video-extra-field">
						<input type="text" name="couple_gallary_videos[]" class="couple-form couple_gallary_videos" placeholder="Add Video Url" value="">

						<div class="cpl-player-type-container">
								<label>Youtube</label>
								<input type="checkbox" name="player-type[]" value="1" class="player-type" checked="checked">

								<label>Vimeo</label>
								<input type="checkbox" name="player-type[]" value="2" class="player-type">
							</div>
					</div>
			<?php } ?>
			</div>
			<span class="append_error"></span>
		</div>

		<!-- Upload Multiple Videos -->
		<?php /* <div class="mt-2p">
	    	<div class="lbl-container display-flex-center">
				<label><strong><span>*</span> Upload Videos</strong></label>
				<div class="btn-container">
					<span class="fa fa-video-camera fa-2x"></span>
					<input type="file" name="couple-gallary-videos[]" class="couple-form" id="couple-gallary-videos" multiple="multiple" onchange="gallaryVideos(event)" accept="video/mp4,video/x-m4v,video/*">
				</div>
			</div>
			<div class="inpt-container" id="couple-video-gallary">
				<div class="append_gallary_video">
					<?php if(!empty($couple_gallary_videos) && count($couple_gallary_videos) > 0){ ?>
						<?php foreach($couple_gallary_videos as $key => $data): ?>
							<div class='gallary-videos'><video width='300px' class='gallary_videos' src='<?php echo $data['url']; ?>' controls></video></div>
						<?php endforeach; ?>
					<?php } ?>
				</div>
			</div>
			<span class="append_error"></span>
		</div> */ ?>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXDeHRKG6uEsXuVVj7IRp2jB5pZbRK4Wg&libraries=places&callback=initMap" async defer></script>
		<script type="text/javascript">
			function readURL(input)
			{
	            if (input.files && input.files[0]) {
	                var reader = new FileReader();

	                reader.onload = function (e) {
	                    jQuery('#profile-image-tag').attr('src', e.target.result);
	                    jQuery('#profile-image-tag').css('display', 'block');
	                };

	                reader.readAsDataURL(input.files[0]);
	            }
	        }

	        var gallaryImages = function(event)
	        {
	        	var output = document.getElementById('append_gallary_images');
	        	var totalFiles = document.getElementById('couple-gallary-image').files.length;
	        	var html = "";
	        	for(var i=0; i<totalFiles;i++)
				{
					html += "<div class='gallary-images'><img id='gallary_image"+i+"' class='gallary_image' src='"+URL.createObjectURL(event.target.files[i])+"'></div>";
					// jQuery('.append_gallary_images').append("<div class='gallary-images'><img id='gallary_image"+i+"' class='gallary_image' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
				}
				jQuery('.append_gallary_images').append(html);
	        }

	   //      var gallaryVideos = function(event)
	   //      {
	   //      	var output = document.getElementById('append_gallary_video');
	   //      	var totalFiles = document.getElementById('couple-gallary-videos').files.length;
	   //      	var html = "";
	   //      	for(var i=0; i<totalFiles;i++)
				// {
				// 	html += "<div class='gallary-images'><video width='300px' id='gallary_videos"+i+"' class='gallary_videos' src='"+URL.createObjectURL(event.target.files[i])+"' controls></video></div>";
				// 	// jQuery('.append_gallary_images').append("<div class='gallary-images'><img id='gallary_image"+i+"' class='gallary_image' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
				// }
				// jQuery('.append_gallary_video').append(html);
	   //      }

	  				function initMap()
	        		{
		        		// Google Address auto complate
				        google.maps.event.addDomListener(window, 'load', function () {
					        var places = new google.maps.places.Autocomplete(document.getElementById('couple-event-location'));
					        google.maps.event.addListener(places, 'place_changed', function () {
					            var place = places.getPlace();
					            var address = place.formatted_address;
					            var latitude = place.geometry.location.A;
					            var longitude = place.geometry.location.F;
					            var mesg = "Address: " + address;
					            mesg += "\nLatitude: " + latitude;
					            mesg += "\nLongitude: " + longitude;
					            // alert(mesg);
					        });
					    });
			    	}

	        jQuery(document).ready(function()
	        	{
	        		jQuery('.ajax-remove').click(function()
	        			{
	        				var img_url = jQuery(this).parent().find('.gallary_image').attr('src');
	        				var img_path = jQuery(this).parent().find('.gallary_image').attr('data-path');
	        				var post_id = "<?php echo $post_id; ?>";
	        				var element_id = jQuery(this).parent().attr('id');
	        				var data = {
								'action': 'my_action',
								'url': img_url,
								'path': img_path,
								'postid': post_id
							};

							// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
							jQuery.post(
								ajaxurl,
								data,
								function(response)
								{
									if(response != '')
									{
										jQuery("#"+element_id).remove();
									}
								}
							);
	        			});

	        		// Add new fields
	        		jQuery('.add_text_field').click(function()
	        			{
	        				var checkbox = '<div class="cpl-player-type-container"><label>Youtube</label><input type="checkbox" name="player-type[]" value="1" checked="checked" class="player-type"><label>Vimeo</label><input type="checkbox" name="player-type[]" value="2" class="player-type"></div>';

	        				var html = '<div class="video-extra-field"><input type="text" name="couple_gallary_videos[]" class="couple-form couple_gallary_videos" placeholder="Add Video Url" value=""><button type="button" class="cpl-remove-text-video-field"><span class="fa fa-close"></span></button>'+checkbox+'</div>';
	        				jQuery('#couple-video-gallary').append(html);
	        				removeField();
	        				checkBoxValidation();
	        			});
	        		function removeField()
	        		{
	        			jQuery('.cpl-remove-text-video-field').click(function()
	        				{
	        					jQuery(this).parent().remove();
	        				});
	        		}
	        		jQuery('.cpl-remove-text-video-field').click(function()
	        			{
	        				jQuery(this).parent().remove();
	        			});

	        		// Video type checkbox validation
	        		function checkBoxValidation()
	        		{
	        			jQuery('.player-type').click(function(e)
	        			{
	        				var attribute = jQuery(this).attr('checked');
	        				if(typeof attribute == "undefined")
	        				{
	        					jQuery(this).attr('checked', 'checked');
	        				}
	        				else
	        				{
	        					jQuery(this).parent().find('.player-type').each(function()
	        						{
	        							jQuery(this).removeAttr('checked');
	        						});
	        					jQuery(this).attr('checked', 'checked');
	        				}
	        			});
	        		}

	        		jQuery('.player-type').click(function(e)
	        			{
	        				var attribute = jQuery(this).attr('checked');
	        				if(typeof attribute == "undefined")
	        				{
	        					jQuery(this).attr('checked', 'checked');
	        				}
	        				else
	        				{
	        					jQuery(this).parent().find('.player-type').each(function()
	        						{
	        							jQuery(this).removeAttr('checked');
	        						});
	        					jQuery(this).attr('checked', 'checked');
	        				}
	        			});

	        	});

		</script>
	</div>
	<?php
}

function update_couple_metas($post_id)
{
	if(isset($_POST['couple-date-event']) && !empty($_POST['couple-date-event']))
	{
		$couple_event_date = $_POST['couple-date-event'];
		update_post_meta($post_id, 'cpl_eve_date', $couple_event_date);
	}
	if(isset($_POST['grid-type']) && !empty($_POST['grid-type']))
	{
		$couple_grid_type = $_POST['grid-type'];
		update_post_meta($post_id, 'cpl_grid_type', $couple_grid_type);
	}
	if(isset($_POST['couple-location']) && !empty($_POST['couple-location']))
	{
		$couple_location = $_POST['couple-location'];
		update_post_meta($post_id, 'cpl_location', $couple_location);
	}
	if(isset($_POST['couple_gallary_videos']) && count($_POST['couple_gallary_videos']) && isset($_POST['player-type']) && !empty($_POST['player-type']))
	{
		$video_type = $_POST['player-type'];
		$couple_videos = $_POST['couple_gallary_videos'];
		$couple_video_counts = count($couple_videos);
		$couple_video_type_arr = array();
		for($i=0; $i<$couple_video_counts;$i++)
		{
			$couple_video_type_arr[] = array(
				'type'	=>	$video_type[$i],
				'link'	=>	$couple_videos[$i]
			);
		}
		if(!empty($couple_video_type_arr) && count($couple_video_type_arr) > 0)
		{
			update_post_meta($post_id, 'couple_gallary_videos', $couple_video_type_arr);
		}
	}
	if(isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] == 0)
	{
		$supported_types = array('jpg', 'jpeg', 'png');
		$arr_file_type = wp_check_filetype(basename($_FILES['profile-image']['name']));
		$uploaded_type = $arr_file_type['type'];
		$uploaded_type = end(explode('/', $uploaded_type));

		if(in_array($uploaded_type, $supported_types)) {
            $upload = wp_upload_bits($_FILES['profile-image']['name'], null, file_get_contents($_FILES['profile-image']['tmp_name']));
            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                update_post_meta($post_id, 'profile_image', $upload);
            }
        }
        else {
            wp_die("The file type that you've uploaded is not a PDF.");
        }
	}
	if(isset($_FILES['couple-gallary-image']))
	{
		$supported_types = array('jpg', 'jpeg', 'png');
		$total_files_count = count($_FILES['couple-gallary-image']['name']);
		$upload_arr = array();

		// Getting previous images
		$pre_image_arr = get_post_meta($post_id,'couple_gallary_images', true);

		for($i=0; $i<$total_files_count; $i++)
		{
			$arr_file_type = wp_check_filetype(basename($_FILES['couple-gallary-image']['name'][$i]));
			$uploaded_type = $arr_file_type['type'];
			$uploaded_type = end(explode('/', $uploaded_type));

			if(in_array($uploaded_type, $supported_types))
			{
				$upload = wp_upload_bits($_FILES['couple-gallary-image']['name'][$i], null, file_get_contents($_FILES['couple-gallary-image']['tmp_name'][$i]));
				$upload_arr[] = $upload;
			}
		}
		
		// Replace slashes
		$n_upload_arr = array();
		if(!empty($upload_arr) && count($upload_arr) > 0)
		{
			foreach($upload_arr as $key1 => $data1):
				$n_upload_arr[] = array(
					'file'	=>	str_replace('\\', '/', $data1['file']),
					'url'	=>	$data1['url'],
					'type'	=>	$data1['type'],
					'error'	=>	$data1['error'],
				);
			endforeach;
		}

		if(!empty($pre_image_arr) && count($pre_image_arr) > 0)
		{
			$n_upload_arr = array_merge($pre_image_arr, $n_upload_arr);
		}

		if(!empty($n_upload_arr) && count($n_upload_arr) > 0)
		{
			update_post_meta($post_id, 'couple_gallary_images', $n_upload_arr);
		}
	}
	// if(isset($_FILES['couple-gallary-videos']))
	// {
	// 	$supported_types = array('mp4', 'wmv', 'avi' ,'flv', 'mov');
	// 	$total_files_count = count($_FILES['couple-gallary-videos']['name']);
	// 	$upload_arr = array();

	// 	for($i=0; $i<$total_files_count; $i++)
	// 	{
	// 		$arr_file_type = wp_check_filetype(basename($_FILES['couple-gallary-videos']['name'][$i]));
	// 		$uploaded_type = $arr_file_type['type'];
	// 		$uploaded_type = end(explode('/', $uploaded_type));

	// 		if(in_array($uploaded_type, $supported_types))
	// 		{
	// 			$upload = wp_upload_bits($_FILES['couple-gallary-videos']['name'][$i], null, file_get_contents($_FILES['couple-gallary-videos']['tmp_name'][$i]));
	// 			$upload_arr[] = $upload;
	// 		}
	// 	}
	// 	if(!empty($upload_arr) && count($upload_arr) > 0)
	// 	{
	// 		update_post_meta($post_id, 'couple_gallary_videos', $upload_arr);
	// 	}
	// }
}
add_action('save_post','update_couple_metas');

?>