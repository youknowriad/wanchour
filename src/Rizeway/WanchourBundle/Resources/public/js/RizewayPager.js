var RizewayPager = function(dom) {

    var dom_object = dom;

    $('.rizeway-pager', dom_object).click(function(e){
        e.preventDefault();
        var pager = $(this);
        $.ajax({
            url: pager.attr('href'),
            type: 'GET',
            success: function(data) {
                if ($.trim(data) !== '') $(data).insertBefore(pager.parents('tr:first'));
                pager.parents('tr:first').remove();
            }
        })
    });

};