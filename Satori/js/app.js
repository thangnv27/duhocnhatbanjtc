$(document).ready(function(){
    
    /* Menu */
    $("ul.navi_bar li").each(function(){
        if($(this).attr('class').lastIndexOf('current-', $(this).attr('class')) != -1){
            $(this).children('a:first').addClass('on');
        }
        if($(this).children('ul.sub-menu').length > 0){
            $(this).append('<div class="submenu"><div class="submenu_ct"><span class="arrow"></span><ul>' + 
                $(this).children('ul.sub-menu').html() +
            '</ul></div></div>');
            $(this).children('ul.sub-menu').remove();
        }
    });
    $(".menu-main-menu-container").show('fast');
    
    
    // enter line
//    $('.detail_ct div, .about_ct div, .add_box_ct div, .kh_detail_ct  div, .post_ct div').each(function(){
    $('.detail_ct div, .about_ct div, .add_box_ct div, .post_ct div').each(function(){
        if($(this).html().length == 0){
            $(this).css({
                'height': '15px'
            });
        }
    });
    $('.kh_detail_ct div[id^="tabs-"]').each(function(){
        $(this).find('div').each(function(){
            if($(this).html().length == 0){
                $(this).css({
                    'height': '15px'
                });
            }
        });
    });
    
    
    /* slide khach hang */
    $('#slider-top').bxSlider({
        nextText: '',
        prevText: '',
        pager: false,
        mode: 'fade',
        auto: true
    });//.css({'left':'0px'});
    
    /*$('#slider-top li a img').each(function(){
        $(this).width($(this).parent().parent().width());
        $(this).height(450);
    });*/
	
    /* slide khach hang */
    $('.kh_slider ul').bxSlider({
        nextSelector: '#kh-btn-next',
        prevSelector: '#kh-btn-prev',
        nextText: '',
        prevText: '',
        pager: false,
        minSlides: 2,
        maxSlides: 2,
        slideWidth: 300,
        slideMargin: 20
    });
	
    /* slide partner */
    if($('.teacher_slide ul li').length > 4){
        $('.teacher_slide ul').bxSlider({
            nextText: '',
            prevText: '',
            pager: false,
            minSlides: 4,
            maxSlides: 4,
            slideWidth: 210,
            slideMargin: 30,
            speed: 2000
        });
    }
	
    /* kh detail tabs */
    $( ".kh_detail_ct" ).tabs();
	
    /* show more less content */
    $('.author_info .intro_ct').expander({
        slicePoint: 300,
        expandText: 'Mở rộng +',
        userCollapseText: 'Thu gọn +',
        expandEffect: 'show',
        expandSpeed: 0,
        collapseEffect: 'hide',
        collapseSpeed: 0
    });
	
    $('.teacher_lst .intro').expander({
        slicePoint: 250,
        expandText: 'Xem chi tiết +',
        userCollapseText: 'Thu gọn +',
        expandEffect: 'show',
        expandSpeed: 0,
        collapseEffect: 'hide',
        collapseSpeed: 0
    });
	
    /* append reg form */
    $('#sl-user-reg').change( function () {
        var option = $(this).val();
        appendfrm(option);
    });
	
    /* fixed kh tabs */
    /*$('.kh_detail_tabs').scrollToFixed({
        limit: $('.kh_other').offset().top
    });*/
	
    /* fixed column right */
    var summaries = $('.r_fixed_limit');
    summaries.each(function(i) {
        var summary = $(summaries[i]);
        var next = summaries[i + 1];

        summary.scrollToFixed({
            marginTop: $('.header').outerHeight(true) + $('#wpadminbar').outerHeight(true) + 10,
            limit: function() {
                var limit = 0;
                if (next) {
                    limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                } else {
                    // footer offset top
                    limit = $('#teacher_box').offset().top - $(this).outerHeight(true) - 10;
                }
                return limit;
            },
            zIndex: 999
        });
    });
	
});

/* function append reg form */
function appendfrm(sl){
    var $temp = $('#frm-reg-temp').val();
    $('#frm-reg').empty();
    for(i=0;i<sl;i++){
        $('#frm-reg').append($temp);
    }
}


	
	
	