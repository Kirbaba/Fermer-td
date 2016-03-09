<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $root = dirname(dirname(__FILE__));
    include($root .'/core/inc/config.php');

    require_once($root .'/core/classes/Database/DatabaseConnect.class.php');
    require_once($root .'/core/classes/Site/Content.class.php');

    $page = new Content();
    $result = $page->partner();
    switch($result['code']){
        case 80:
            $response['title'] = 'Не заполнено поле';
            $response['msg'] = 'Поле "'. $result['replace'] .'" обязательно к заполнению';
            break;
        case 88:
            $response['title'] = 'Ваше письмо отправлено';
            $response['msg'] = 'Мы свяжемся с Вами в близжайшее время.';
            break;
        case 86:
            $response['title'] = 'Произошла ошибка';
            $response['msg'] = 'Не удалось отправить заявку. Повторите поптку чуть позже.';
            break;
    }

    return print json_encode($response);
}
?>