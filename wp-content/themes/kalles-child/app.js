(function($) {
    $(window).on('load', function(){
        let allFilter = $('.the4-filter-wrap').find('.wrap_filter>.col-12>.widget-title');
        $.each(allFilter, function(index, value){
            if(value.outerText == 'по Цвет для фильтров'){
                $(this).text("По цвету")
            }
            if(value.outerText == 'по Размер'){
                $(this).text('По размеру')
            }
            if(value.outerText == 'по Цена'){
                $(this).text('По цене')
            }
        });
        $('.the4-banner a').removeAttr('target');
    });
})(jQuery);