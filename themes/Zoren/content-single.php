<?php
/**
 * @package web2feel
 * @since web2feel 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
				$thumb = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
				$image = aq_resize( $img_url, 880, 400, true ); //resize & crop the image
			?>
				
			<?php if($image) : ?>
				<a href="<?php the_permalink(); ?>"><img class="postimg responsive" src="<?php echo $image ?>"/></a>
			<?php endif; ?>
			<div class="entry-meta cf">
			
				<div class="author-meta ">
					<p>POSTED BY</p> 
					<span><?php the_author_posts_link(); ?></span>
				</div>
				
				<div class="clock-meta">
					<p>POSTED ON</p>
					<span><?php the_time('F j, Y'); ?></span>
				</div>
				
				<div class="category-meta">
					<p>POSTED UNDER</p>
					<span> <?php the_category(', '); ?></span>
				</div>
				
				<div class="commnt-meta">
					<p>COMMENTS</p> 
					<span><?php comments_popup_link(__('0 Comments', 'themeblokes'), __('1 Comment', 'themeblokes'), __('% Comments', 'themeblokes')); ?></span>
				</div>						
				
			</div><!-- .entry-meta -->

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'web2feel' ), 'after' => '</div>' ) ); ?>
		
		<div class="taglist cf"> <?php   if(get_the_tag_list()) {
				echo get_the_tag_list('<ul><li>','</li><li>','</li></ul>');
									} ?>
		</div> 
					
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
