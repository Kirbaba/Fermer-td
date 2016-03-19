<?php get_header(); ?>
	<div class="bxslider_w after">
	</div>
<div class="catalog">
	<h1 class="titleImg p_rel">Сервисы<span class="brd db"></span></h1>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
	<?php  endif;?>
</div>
<?php get_footer(); ?>