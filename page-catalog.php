<?php get_header(); ?>
<div class="bxslider_w shop after">
	<ul class="bxslider">
		<li>
			<img src="<?php bloginfo('template_directory'); ?>/slides/43f3f41c.png" alt="текст слайда">
		</li>
		<li>
			<img src="<?php bloginfo('template_directory'); ?>/slides/cf99795f.png" alt="текст слайда">
		</li>
	</ul>
</div>
<div class="catalog">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
	<?php  endif;?>
</div>
<?php get_footer(); ?>