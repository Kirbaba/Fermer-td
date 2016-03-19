<?php

define('TM_DIR', get_template_directory(__FILE__));
define('TM_URL', get_template_directory_uri(__FILE__));

require_once TM_DIR . '/lib/Parser.php';

function add_style(){
    wp_enqueue_style( 'my-styles', get_template_directory_uri() . '/css/css.css', array(), '1');
    wp_enqueue_style( 'bxslider', get_template_directory_uri() . '/js/bxslider/jquery.bxslider.css', array(), '1');
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1');
}

function add_script(){    
    wp_enqueue_script( 'jq-1_8', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js', array(), '1');
    wp_enqueue_script( 'jq', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array(), '1');    
    wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/js/bxslider/jquery.bxslider.min.js', array(), '1');
    wp_enqueue_script( 'bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1');
    wp_enqueue_script( 'my-script', get_template_directory_uri() . '/js/js.js', array(), '1');
    wp_localize_script( 'my-script', 'myajax',
    array(
        'url' => get_template_directory_uri().'/img/',
        'act' => admin_url('admin-ajax.php')
    ));
}

function add_admin_script(){
    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array(), '1');
    wp_enqueue_script('admin',get_template_directory_uri() . '/js/admin.js', array(), '1');
    wp_enqueue_style( 'my-bootstrap-extension-admin', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1');
    wp_enqueue_script( 'my-bootstrap-extension', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1');
    wp_enqueue_style( 'my-style-admin', get_template_directory_uri() . '/css/admin.css', array(), '1');
}

add_action('admin_enqueue_scripts', 'add_admin_script');
add_action( 'wp_enqueue_scripts', 'add_style' );
add_action( 'wp_enqueue_scripts', 'add_script' );

function prn($content) {
    echo '<pre style="background: lightgray; border: 1px solid black; padding: 2px">';
    print_r ( $content );
    echo '</pre>';
}

function my_pagenavi() {
    global $wp_query;

    $big = 999999999; // уникальное число для замены

    $args = array(
        'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) )
    ,'format' => ''
    ,'current' => max( 1, get_query_var('paged') )
    ,'total' => $wp_query->max_num_pages
    );

    $result = paginate_links( $args );

    // удаляем добавку к пагинации для первой страницы
    $result = str_replace( '/page/1/', '', $result );

    echo $result;
}

function excerpt_readmore($more) {
    return '... <br><a href="'. get_permalink($post->ID) . '" class="readmore">' . 'Читать далее' . '</a>';
}
add_filter('excerpt_more', 'excerpt_readmore');

if ( function_exists( 'add_theme_support' ) )
    add_theme_support( 'post-thumbnails' );

function mainCategoriesShortcode(){
    $args = array(
        'type'         => 'post',
        'child_of'     => 0,
        'parent'       => '0',
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => 0,
        'hierarchical' => 1,
        'exclude'      => '1,3',
        'include'      => '',
        'number'       => 0,
        'taxonomy'     => 'catalog',
        'pad_counts'   => false,
        // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
    );
    $categories = get_categories( $args );
  //  prn($categories);

    $parser = new Parser();
    $parser->render(TM_DIR . '/view/categories.php', ['categories' => $categories]);
}

add_shortcode('categories','mainCategoriesShortcode');

/*--------------------------------------------------------CATALOG-----------------------------------------------------*/

/* Сохраняем данные, при сохранении поста */
add_action('save_post', 'myExtraFieldsUpdate', 10, 1);
function myExtraFieldsUpdate($post_id)
{
    if (!isset($_POST['extra'])) return false;
    foreach ($_POST['extra'] as $key => $value) {
        if (empty($value)) {
            delete_post_meta($post_id, $key); // удаляем поле если значение пустое
            continue;
        }

        update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
    }
    return $post_id;
}

function extraFieldsStorePrice($post)
{
    ?>
    <p>
        <span>Цена (для каталога): </span>
        <input type="text" name='extra[price]' value="<?php echo get_post_meta($post->ID, "price", 1); ?>">
    </p>
    <?php
}
/* custom post type*/
add_action('init', 'customInitCatalog');

// Custom ingredients taxonomy
function add_catalog_taxonomies() {
    register_taxonomy('catalog', 'catalogue', array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Категории', 'taxonomy general name' ),
            'singular_name' => _x( 'Категория', 'taxonomy singular name' ),
            'search_items' =>  __( 'Поиск категорий' ),
            'all_items' => __( 'Все категории' ),
            'parent_item' => __( 'Родитель' ),
            'parent_item_colon' => __( 'Родитель:' ),
            'edit_item' => __( 'Редактировать категорию' ),
            'update_item' => __( 'Обновить категорию' ),
            'add_new_item' => __( 'Добавить новую категорию' ),
            'new_item_name' => __( 'Новое название категории' ),
            'menu_name' => __( 'Категории' ),
        ),

        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'catalog', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));
}
add_action( 'init', 'add_catalog_taxonomies', 0 );

function customInitCatalog()
{
    $labels = array(
        'name' => 'Каталог', // Основное название типа записи
        'singular_name' => 'Каталог', // отдельное название записи типа Book
        'add_new' => 'Добавить товар',
        'add_new_item' => 'Добавить новый товар',
        'edit_item' => 'Редактировать товар',
        'new_item' => 'Новый товар',
        'view_item' => 'Посмотреть товар',
        'search_items' => 'Найти товар',
        'not_found' => 'Товаров не найдено',
        'not_found_in_trash' => 'В корзине товаров не найдено',
        'parent_item_colon' => '',
        'menu_name' => 'Каталог'

    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'thumbnail','editor')
    );
    register_post_type('catalogue', $args);
}
// AJAX ACTION
add_action('wp_ajax_sendCallback', 'sendCallback');
add_action('wp_ajax_nopriv_sendCallback', 'sendCallback');

function sendCallback(){
    //prn($_POST);
    $adminMail = get_option('admin_email');
    $phone =  $_POST['phone'];
    $mail = $_POST['mail'];
    $message = $_POST['message'];
    $product = $_POST['product'];

    $tovar = get_post($product);
    $price = get_post_meta($tovar->ID,'price',1);
    if(!empty($mail)){

        $str = "С вашего сайта оставили заявку на товар:<br>";
        $str .= $tovar->post_title.", ".$price." руб.<br>";
        $str .= 'Почта: '.$mail.' <br>';
        $str .= 'Телефон: '.$phone.' <br>';
        $str .= 'Текст сообщения: '.$message.' <br>';

        mail($adminMail, "Письмо с сайта Шторы", $str, "Content-type: text/html; charset=UTF-8\r\n");

        echo 1;
    }else{
        echo 0;
    }

    die();
}

function extraFieldsStoreComponents($post)
{

    echo "<p><span>Описание (для каталога): </span>";
    wp_editor(get_post_meta($post->ID, "components", 1), 'editor_id', array(
        'wpautop' => 1,
        'media_buttons' => 1,
        'textarea_name' => 'extra[components]', //нужно указывать!
        'textarea_rows' => 20,
        'tabindex'      => null,
        'editor_css'    => '',
        'editor_class'  => '',
        'teeny'         => 0,
        'dfw'           => 0,
        'tinymce'       => 1,
        'quicktags'     => 1,
        'drag_drop_upload' => false
    ) );
    echo "</p>";
}

function myExtraFieldsStore()
{
    add_meta_box('extra_price', 'Цена', 'extraFieldsStorePrice', 'catalogue', 'normal', 'high');
    add_meta_box('extra_price', 'Цена', 'extraFieldsStorePrice', 'service', 'normal', 'high');
    add_meta_box('extra_components', 'Компоненты', 'extraFieldsStoreComponents', 'catalogue', 'normal', 'high');
    add_meta_box('extra_components', 'Компоненты', 'extraFieldsStoreComponents', 'service', 'normal', 'high');
}

add_action('add_meta_boxes', 'myExtraFieldsStore', 1);
/*products*/

/*----------------------------------------------------END CATALOG-----------------------------------------------------*/
/*-------------------------------------------------------SERVICES-----------------------------------------------------*/

/*сервисы*/

function customInitServices()
{
    $labels = array(
        'name' => 'Сервисы', // Основное название типа записи
        'singular_name' => 'Сервисы', // отдельное название записи типа Book
        'add_new' => 'Добавить сервис',
        'add_new_item' => 'Добавить новый сервис',
        'edit_item' => 'Редактировать сервис',
        'new_item' => 'Новый сервис',
        'view_item' => 'Посмотреть сервис',
        'search_items' => 'Найти сервис',
        'not_found' => 'Сервисов не найдено',
        'not_found_in_trash' => 'В корзине сервисов не найдено',
        'parent_item_colon' => '',
        'menu_name' => 'Сервисы'

    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'thumbnail','editor')
    );
    register_post_type('service', $args);
}
add_action('init', 'customInitServices');

// Custom menu
function add_services_taxonomies() {
    register_taxonomy('services', 'service', array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Категории', 'taxonomy general name' ),
            'singular_name' => _x( 'Категория', 'taxonomy singular name' ),
            'search_items' =>  __( 'Поиск категорий' ),
            'all_items' => __( 'Все категории' ),
            'parent_item' => __( 'Родитель' ),
            'parent_item_colon' => __( 'Родитель:' ),
            'edit_item' => __( 'Редактировать категорию' ),
            'update_item' => __( 'Обновить категорию' ),
            'add_new_item' => __( 'Добавить новую категорию' ),
            'new_item_name' => __( 'Новое название категории' ),
            'menu_name' => __( 'Категории' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'services', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));
}
add_action( 'init', 'add_services_taxonomies', 0 );

function mainServicesShortcode(){
    $args = array(
        'type'         => 'post',
        'child_of'     => 0,
        'parent'       => '0',
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => 0,
        'hierarchical' => 1,
        'exclude'      => '1,3',
        'include'      => '',
        'number'       => 0,
        'taxonomy'     => 'services',
        'pad_counts'   => false,
        // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
    );
    $categories = get_categories( $args );
    //  prn($categories);

    $parser = new Parser();
    $parser->render(TM_DIR . '/view/categories.php', ['categories' => $categories]);
}

add_shortcode('services','mainServicesShortcode');

/*---------------------------------------------------END SERVICES-----------------------------------------------------*/