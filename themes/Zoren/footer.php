<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package web2feel
 * @since web2feel 1.0
 */
?>

	</div><!-- #main .site-main -->
<!--	<div class="thickline block-7-8-9-10"></div>-->
	<footer id="colophon" class="site-footer block-7-8-9-10" role="contentinfo">
        <div class="footer-slider">
            <?php echo do_shortcode('[print_thumbnail_slider]'); ?>
        </div>
		<div class="site-info">
			<div class="fcred">
			Copyright &copy; <?php echo date('Y');?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a><?php bloginfo('description'); ?>.<br />
<?php fflink(); ?> | <a href="http://ffgroup.kharkov.com/" target="_blank"><?php echo __('Site by FFGroup'); ?></a>
			</div>		

		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
