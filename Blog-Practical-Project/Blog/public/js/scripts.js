+function ($) {
    'use strict';
    $('.nav-pills').on('click', function(){
        $('.nav-pills li').removeClass('active');
        this.addClass('active');
    });
 }(jQuery);
