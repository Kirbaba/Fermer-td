<?php get_header(); ?>
<div class="news_w">
	<div class="history_w fr">
		<div class="social after">Добавляйте Нас в друзья!<br>И следите за нашими новостями!</div>
		<div class="after">
			<!-- <a href=""><i class="vk icon db fl"></i></a>
			<a href=""><i class="fb icon db fl"></i></a>
			<a href=""><i class="ig icon db fl"></i></a> -->
			<i class="vk icon db fl"></i>
			<i class="fb icon db fl"></i>
			<i class="ig icon db fl"></i>
		</div>
		<div class="history">
			<!-- Архив
			<ul class="month">
					<li><a href="">&dash; Июнь 2015</a></li>
					<li><a href="">&dash; Май 2015</a></li>
					<li><a href="">&dash; Апрель 2015</a></li>
					<li><a href="">&dash; Февраль 2015</a></li>
					<li><a href="">&dash; Декабрь 2014</a></li>
					<li><a href="">&dash; Ноябрь 2014</a></li>
					<li><a href="">&dash; Сентябрь 2014</a></li>
					<li><a href="">&dash; Август 2014</a></li>
			</ul>-->
		</div>
	</div>
	<div class="newsList">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="news">
			<div class="news">
				<?php the_post_thumbnail(); ?>
				<a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="title db"><?php the_title(); ?></a>
				<?php the_content(); ?>
				<p class="share">Поделиться новостью</p>
				<div class="after">
					<a href="http://vk.com/share.php?url=<?php echo get_the_permalink(get_the_ID()); ?>"><i class="vk icon db fl"></i></a>
					<a href="http://www.facebook.com/sharer.php?u=<?php echo get_the_permalink(get_the_ID()); ?>"><i class="fb icon db fl"></i></a>
				</div>
				<div class="date before"><?php echo get_the_date("n/j/Y"); ?></div>
			</div>
		</div>
<?php endwhile; ?>
<?php  endif;?>
	</div>
</div>
<?php get_footer(); ?>