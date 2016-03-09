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
});