<?php
get_header();
$current_id = get_the_ID();
$post = get_post($current_id);
$couple_name = $post->post_title;
$couple_description = $post->post_content;
$couple_cover_image = wp_get_attachment_url( get_post_thumbnail_id($current_id));
$couple_profile_image = get_post_meta($current_id, 'profile_image', true);
$couple_profile_image = $couple_profile_image['url'];
$couple_event_date = get_post_meta($current_id, 'cpl_eve_date', true);
$couple_event_location = get_post_meta($current_id, 'cpl_location', true);
$couple_gallary_photo = get_post_meta($current_id, 'couple_gallary_images', true);
$couple_gallary_video = get_post_meta($current_id, 'couple_gallary_videos', true);
$couple_grid_type = get_post_meta($current_id, 'cpl_grid_type', true);
?>
<div class="cpl-container">
	<!-- top banner start -->
	<div class="cpl-top-banner" style="background: url(<?php echo $couple_cover_image; ?>) center center;"></div>
	<!-- top banner end -->

	<!-- after banner section start -->
	<div class="cpl-profile-container bg-off-white">
		<div class="cpl-row">
			<div class="cpl-pg-container pt-15 pb-15 display-flex justify-space-between mob-block">
				<div class="cpl-left">
					<div class="cpl-personal-details display-flex-center mob-justify-center mob-pt-20 mob-pb-20">
						<img src="<?php echo $couple_profile_image; ?>" class="cpl-profile-img mr-10">
						<span class="cpl-name display-content cpl-heading"><?php echo $couple_name; ?></span><br>
						<span class="cpl-event-date display-content cpl-sub-heading">Married in <?php echo date('F Y', strtotime($couple_event_date)); ?></span><br>
						<span class="cpl-event-location display-content cpl-sub-heading"><?php echo $couple_event_location; ?></span>
					</div>
				</div>
				<div class="cpl-right">
					<div class="cpl-social-icon-container mt-5 mob-text-center mob-pt-20 mob-pb-20">
						<a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink($current_id)); ?>&t=<?php echo urlencode($couple_name); ?>" class="cpl-fb-link">
							<img width="40px" src="<?php echo plugins_url('/images/social-icons/facebook-png.png', __FILE__); ?>" class="cpl-fb-img">
						</a>
						<a target="_blank" href="http://twitter.com/share?text=Currently reading <?php echo urlencode($couple_name); ?>&url=<?php echo urlencode(get_permalink($current_id)); ?>" class="cpl-twit-link">
							<img width="40px" src="<?php echo plugins_url('/images/social-icons/twitter-png.png', __FILE__); ?>" class="cpl-twit-img">
						</a>
						<a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($current_id)); ?>&media=<?php echo urlencode($couple_cover_image); ?>&description=<?php echo urlencode($couple_description); ?>&title=<?php echo urlencode($couple_name); ?>" class="cpl-pin-link">
							<img width="40px" src="<?php echo plugins_url('/images/social-icons/pinterest-png.png', __FILE__); ?>" class="cpl-pin-img">
						</a>
						<?php /*<a href="javascript:void(0)" class="cpl-insta-link">
							<img width="40px" src="<?php echo plugins_url('/images/social-icons/instagram-png.png', __FILE__); ?>" class="cpl-insta-img">
						</a> */ ?>
					</div>
				</div>
			</div>
		</div>
		<div class="cpl-row">
			<div class="cpl-pg-container">
				<div class="cpl-video-photo-tag-container">
					<div class="cpl-v-p-tags cpl-text-center pb-5">
						<a href="javascript:void(0)" id="cpl-video-tag" class="cpl-video-tag cpl-tag active" onclick="displayVideos()">
							VIDEOS
						</a>
						<a href="javascript:void(0)" id="cpl-photo-tag" class="cpl-photo-tag cpl-tag" onclick="displayPhotos()">
							PHOTOS
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- after banner section end -->

	<!-- Couple Description Section start -->
	<div class="cpl-description-container">
		<div class="cpl-row">
			<div class="cpl-pg-container">
				<div class="cpl-description cpl-text-center pt-40 pb-40"><?php echo $couple_description; ?></div>
			</div>
		</div>
	</div>
	<!-- Couple Description Section End -->

	<!-- Couple videos and photos section start -->
	<div class="cpl-video-photo-ele-container">
		<div class="cpl-row">
			<div class="cpl-pg-container">
				<div class="cpl-video-ele-container display-flex flex-wrap justify-space-between mob-rvm-justify" id="cpl-video-ele-container">
					<?php if(!empty($couple_gallary_video) && count($couple_gallary_video) > 0){ ?>
						<?php foreach($couple_gallary_video as $key => $data): ?>
							<!-- <video class="p-5 cpl-w-300 mob-cpl-w-250" src="<?php // echo $data; ?>" controls loop></video> -->
							<?php 
								if($data['type'] == 1)
								{
									if(strpos($data['link'], 'watch') !== false)
									{
										$link = str_replace('watch?v=', 'embed/', $data['link']);
									}
									else
									{
										$link = end(explode('/', $data['link']));
										$link = "https://www.youtube.com/embed/".$link;
									}
								}
								else
								{
									$vimeo_link = $data['link'];
									$vimeo_link = explode('//', $vimeo_link);
									$new_vimeo  = $vimeo_link[0]."//player.".$vimeo_link[1];
									$new_vimeo  = explode('.com', $new_vimeo);
									$link 		= $new_vimeo[0].'.com/video'.$new_vimeo[1];
								}
							?>
							<div class="p-5 cpl-w-300 mob-cpl-w-100-p video mob-cpl-w-265 mob-cpl-w-pc-355">
								<iframe class="cpl-fram-videos" src="<?php echo $link; ?>" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>
							</div>
						<?php endforeach; ?>
					<?php } ?>
				</div>
				<div class="cpl-photo-ele-container cpl-display-none mob-text-center" id="cpl-photo-ele-container">
					<?php if(!empty($couple_gallary_photo) && count($couple_gallary_photo) > 0){ ?>
						<div class="<?php if($couple_grid_type == 1) { echo "grid"; } ?> gallery <?php if($couple_grid_type == 2 || $couple_grid_type == 3) { echo "display-flex flex-wrap justify-space-around"; } ?>">
						<?php foreach($couple_gallary_photo as $key1 => $data1): ?>
								<?php if($couple_grid_type == 1) { ?>
									<div class="grid-item">
								<?php } ?>
									<a href="<?php echo $data1['url']; ?>" class="big">
										<?php if($couple_grid_type == 1) { ?>
											<img class="cpl-w-300 mob-cpl-w-250" src="<?php echo $data1['url']; ?>">
										<?php } ?>
										<?php if($couple_grid_type == 2){ ?>
											<div class="cpl-w-450 m-5 mob-w-300" style="background-image: url('<?php echo $data1["url"]; ?>'); width: 450px; height: 450px; background-size: cover; background-position: center center;">
											</div>
										<?php } ?>
										<?php if($couple_grid_type == 3){ ?>
											<div class="cpl-w-300 m-5" style="background-image: url('<?php echo $data1["url"]; ?>'); width: 300px; height: 300px; background-size: cover; background-position: center center;">
											</div>
										<?php } ?>
									</a>
								<?php if($couple_grid_type == 1) { ?>
									</div>
								<?php } ?>
						<?php endforeach; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<!-- Couple videos and photos section end -->
</div>
<?php get_footer(); ?>