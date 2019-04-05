<?php

	function my_action()
	{
		$image_url = $_POST['url'];
		$image_path = $_POST['path'];
		$postId = $_POST['postid'];
		// Get images by post id
		$image_arr = get_post_meta($postId, 'couple_gallary_images', true);
		$new_arr = array();
		if(!empty($image_arr) && count($image_arr) > 0)
		{
			foreach($image_arr as $key => $data):
				if($data['url'] != $image_url)
				{
					$new_arr[] = $data;
				}
			endforeach;

			if(!empty($new_arr) && count($new_arr) > 0)
			{
				unlink($image_path);
				update_post_meta($postId, 'couple_gallary_images', $new_arr);
				echo "success";
			}
			else
			{
				unlink($image_path);
				delete_post_meta($postId, 'couple_gallary_images');
				echo "success";
			}
		}

		exit();
	}
	add_action( 'wp_ajax_my_action', 'my_action' );
	add_action( 'wp_ajax_nopriv_my_action', 'my_action' );
?>