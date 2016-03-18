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
		<?php

		$cat = get_query_var('cat');
		$args = array(
			'type'         => 'post',
			'child_of'     => 0,
			'parent'       => $cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 0,
			'hierarchical' => 1,
			'exclude'      => '1',
			'include'      => '',
			'number'       => 0,
			'taxonomy'     => 'category',
			'pad_counts'   => false,
			// полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
		);
		$categories = get_categories( $args );
		if(!empty($categories)){
		?>
		<div class="products_w after">
			<?php foreach($categories as $category){ ?>
				<div class="product fl">
					<img src="<?php echo z_taxonomy_image_url($category->term_id); ?>" alt="<?php echo $category->name; ?>">
					<a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo $category->name; ?></a>
				</div>

			<?php } ?>
		</div>
		<?php }else{ ?>
	<div class="products_w after">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="product fl">
					<?php the_post_thumbnail(); ?>
					<a href="<?php echo get_the_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
				</div>
			<?php endwhile; ?>
			<?php  endif;?>
	</div>
		<?php } ?>
</div>
<?php get_footer(); ?>