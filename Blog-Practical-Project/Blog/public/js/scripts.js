activeButton = function ($) {
    'use strict';
    $('.nav-pills').on('click', function(){
        $('.nav-pills li').removeClass('active');
        this.addClass('active');
    });
 }(jQuery);

requester = function ($) {
    function requester(url, success){
        $.ajax({
            method: 'POST',
            url: url
        }).success(function (data) {
            success(data);
        }).error(function (error) {
            console.log(error);
        });
    }

    function toggleVisibility(id) {
        requester('/problems/toggle-visibility/' + id, function(){
            $checkbox =  $('label#' + id + ' input');
            check = $checkbox.prop('checked');
            if(check){
                $checkbox.prop('checked', false);
            } else {
                $checkbox.prop('checked', true);
            }
        });
    }

    return {
        toggleVisibility : toggleVisibility
    }
}(jQuery);

events = function ($) {
    $('label[name=visibility]').on('click', function(ev){
        requester.toggleVisibility(ev.target.id);
    })
}(jQuery)
