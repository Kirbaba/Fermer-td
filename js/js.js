$(document).ready(function(){
    $('.bxslider').bxSlider({
        auto: true,
        mode: 'fade'
    });

    //добавляем страницу в бд
    $('#partner').on('submit', function(){
        var form = $(this);
        var qString = form.serialize();
        $.post('/ajax/post.php', qString, function(data){
            var response = $.parseJSON(data);
            $('.popup .title').text(response.title);
            $('.popup .text').text(response.msg);
            $('.w_popup').removeClass('dn');
        });
        return false;
    });

    p = $('.w_popup');
    p.click(function(event)
    {
        e = event || window.event
        if (e.target == this)
        {
            close_popup();
        }
    });
    function close_popup(){
        p.addClass('dn');
        p.children().addClass('dn');
    }

    $(document).on('click', '.js-open-modal', function () {
        var type = $(this).attr('data-product');
        $('input[name="s_product"]').val(type);
        return false;
    });
    $(document).on('click', '.js-send-modal', function () {

        var name = $('input[name="s_mail"]').val();
        var phone = $('input[name="s_phone"]').val();
        var message = $('textarea[name="s_msg"]').val();
        var type = $('input[name="s_product"]').val();
        jQuery.ajax({
            url: myajax.act,
            type: "POST",
            data: "action=sendCallback&mail=" + name + "&phone=" + phone + "&message=" + message + "&product=" + type,
            success: function (data) {
                $('input[name="s_mail"]').val("");
                $('input[name="s_phone"]').val("");
                $('textarea[name="s_msg"]').val("");
                $('input[name="s_product"]').val("");
                $('#myModal').modal("hide");
            }
        });
        return false;
    });
});