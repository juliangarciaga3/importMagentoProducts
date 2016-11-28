;(function($){$(document).ready(function(){
    //home cats sliders
    if($.fn.bxSlider) $('#cat_slider > ul').bxSlider({
        speed: 3000,
        pause: 4000,
        minSlides:1,
        infiniteLoop:true,
        maxSlides: 8,
        slideWidth: 200,
        slideMargin:22,
        pager: false,
        controls: true,
        auto:true,
        autoDelay: 5000
    });

    if($jq.fn.bxSlider) $jq('#related .category-products ul').bxSlider({
        speed: 3000,
        pause: 4000,
        minSlides:4,
        infiniteLoop:true,
        maxSlides: 8,
        slideWidth: 200,
        slideMargin:22,
        pager: false,
        controls: false,
        auto:true,
        autoDelay: 5000
    });

    //home blocks height
    var $home_blocks=$('#home_blocks'),
        $img1=$home_blocks.find('.col-sm-6:nth-child(1) img'),
        $img2=$home_blocks.find('.col-sm-6:nth-child(2) img:nth-child(1)'),
        $img3=$home_blocks.find('.col-sm-6:nth-child(2) img:nth-child(2)'),
        left_h=$img1.height(),
        right_h=$img2.height()+$img3.height(),
        diff=left_h-right_h;

    if(diff){ $img3.css('margin-top', diff+'px') }

    //quick access
    var $layer=$('#layer'),
        $buttons=$('#quick_access').find('a'),
        $modals=$('div[id^=modal-]');

    $buttons.click(function(e){
        e.preventDefault();
        $layer.show();
        $($(this).attr('href')).fadeIn();
    });

    $modals.find('.fa-close').click(function(e){
        e.preventDefault();
        $(this).parent().parent().hide();
        $layer.fadeOut();
    });

    $('.top-cart-wrapper').click(function(){ window.location=home_url+"/checkout/cart/"; });

    //summertime
    //alert('Vacaciones del 7 al 30 de Agosto. Los pedidos se servirán a partir del 31 de Agosto.');

})})(jQuery);