<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17.03.2016
 * Time: 15:12
 */
?>
    <div class="products_w after">
<?php foreach($categories as $category){ ?>

        <div class="product fl">
            <img src="<?php echo z_taxonomy_image_url($category->term_id); ?>" alt="<?php echo $category->name; ?>">
            <a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo $category->name; ?></a>
        </div>

<?php } ?>
    </div>
