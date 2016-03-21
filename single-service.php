<?php get_header(); ?>
<!--<div class="product_photo p_rel">-->
<!--	<img class="p_abs" src="--><?php //bloginfo('template_directory'); ?><!--/img/products/b_26d8959a.png" alt="Крем-суп с белыми грибами">-->
<!--</div>-->
	<div class="bxslider_w after">
	</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="product_w">
	<div class="product_img fl">
		<?php the_post_thumbnail(); ?>
	</div>
	<div class="product_img_thumbs">
		<?php $attachments = new Attachments( 'my_attachments' ); /* pass the instance name */ ?>
		<?php if( $attachments->exist() ) : ?>
			<?php while( $attachment = $attachments->get() ) : ?>
				<img class="product_img_mini" src="<?php echo $attachments->src( 'full' ); ?>" alt="">
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
	<div class="product_descr">
		<h1 class="titleImg p_rel"><?php the_title(); ?><span class="brd db"></span></h1>
		<p class="title">Описание и стандартное оборудование:</p>
		<?php echo get_post_meta(get_the_ID(), "components", 1); ?>
		<div class="after"></div>
		<?php the_content(); ?>
		<div class="line"></div>
		<table>
			<tbody>
				<tr>
					<td class="left">Цена:      <?php echo get_post_meta(get_the_ID(), "price", 1);?> руб.</td>
				</tr>
			</tbody>
		</table>
		<a class="db btn js-open-modal" href="#" data-toggle="modal" data-target="#myModal" data-product="<?php echo get_the_ID(); ?>">Заказать</a>
	</div>
<?php endwhile; ?>
<?php  endif;?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="form_w">
					<p class="title">Заказ товара</p>
					<p class="text">Пожалуйста, заполните форму.<br>Наш менеджер связется с Вами в близжайшее время.</p>
<!--					<form id="partner" action="" method="post">-->
						<fieldset>
							<label>E-mail*</label>
							<input type="text" name="s_mail" value="">
							<label>Контактный телефон*</label>
							<input type="text" name="s_phone" value="">
							<input type="hidden" name="s_product" value="">
							<label>Текст письма*</label>
							<textarea name="s_msg"></textarea>
							<p class="notice">все поля, отмеченные *, обязательны для заполнения</p>
							<button class="btn db js-send-modal">отправить</button>
						</fieldset>
<!--					</form>-->
				</div>
			</div>
		</div>
	</div>
<!--	<div class="linked_w after">-->
<!--		<p class="title">Попробуйте другие наши блюда</p>-->
<!--		<div class="linkedProduct fl">-->
<!--			<img src="--><?php //bloginfo('template_directory'); ?><!--/img/products/s_b9afe576.png" alt="Ризотто с белыми грибами">-->
<!--			<a href="/product/risotto/">Ризотто с белыми грибами</a>-->
<!--		</div>-->
<!--		<div class="linkedProduct fl">-->
<!--			<img src="--><?php //bloginfo('template_directory'); ?><!--/img/products/s_0645ead2.png" alt="Ризотто с креветками  в сливочном соусе">-->
<!--			<a href="/product/risotto_shrimp_in_creamy_sauce/">Ризотто с креветками  в сливочном соусе</a>-->
<!--		</div>-->
<!--		<div class="linkedProduct fl">-->
<!--			<img src="--><?php //bloginfo('template_directory'); ?><!--/img/products/s_91d775fd.png" alt="Ризотто  с овощами">-->
<!--			<a href="/product/risotto_with_vegetables/">Ризотто  с овощами</a>-->
<!--		</div>-->
<!--		<div class="linkedProduct fl">-->
<!--			<img src="--><?php //bloginfo('template_directory'); ?><!--/img/products/s_e11be9d6.png" alt="Крем-суп тыквенный  с креветками">-->
<!--			<a href="/product/pumpkin_cream_soup_with_prawns/">Крем-суп тыквенный  с креветками</a>-->
<!--		</div>-->
<!--		<div class="linkedProduct fl">-->
<!--			<img src="--><?php //bloginfo('template_directory'); ?><!--/img/products/s_f5b06df3.png" alt="Суп-пюре  томатный">-->
<!--			<a href="/product/tomato_soup/">Суп-пюре  томатный</a>-->
<!--		</div>-->
<!--	</div>-->
<?php get_footer(); ?>